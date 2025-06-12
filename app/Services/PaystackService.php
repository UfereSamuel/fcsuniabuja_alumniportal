<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;
use Yabacon\Paystack;
use Illuminate\Support\Facades\Log;
use Exception;

class PaystackService
{
    protected $paystack;
    protected $publicKey;
    protected $secretKey;

    public function __construct()
    {
        $this->publicKey = config('services.paystack.public_key');
        $this->secretKey = config('services.paystack.secret_key');
        $this->paystack = new Paystack($this->secretKey);
    }

    /**
     * Initialize a payment transaction
     */
    public function initializePayment(User $user, float $amount, string $category = 'membership', string $description = null): array
    {
        try {
            // Generate unique reference
            $reference = Payment::generateReference();

            // Create payment record
            $payment = Payment::create([
                'user_id' => $user->id,
                'zone_id' => $user->zone_id,
                'amount' => $amount,
                'category' => $category,
                'payment_reference' => $reference,
                'description' => $description ?: $this->getDefaultDescription($category),
                'status' => 'pending',
            ]);

            // Initialize transaction with Paystack
            $tranx = $this->paystack->transaction->initialize([
                'amount' => $amount * 100, // Paystack expects amount in kobo
                'email' => $user->email,
                'reference' => $reference,
                'currency' => 'NGN',
                'callback_url' => route('payments.callback'),
                'metadata' => [
                    'user_id' => $user->id,
                    'payment_id' => $payment->id,
                    'category' => $category,
                    'zone_id' => $user->zone_id,
                    'custom_fields' => [
                        [
                            'display_name' => 'Payment Category',
                            'variable_name' => 'category',
                            'value' => ucfirst($category)
                        ],
                        [
                            'display_name' => 'User Name',
                            'variable_name' => 'user_name',
                            'value' => $user->name
                        ]
                    ]
                ]
            ]);

            // Update payment with Paystack response
            $payment->update([
                'paystack_response' => $tranx->data
            ]);

            return [
                'success' => true,
                'data' => $tranx->data,
                'payment' => $payment,
                'authorization_url' => $tranx->data->authorization_url,
                'reference' => $reference
            ];

        } catch (Exception $e) {
            Log::error('Paystack initialization error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Payment initialization failed. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify payment transaction
     */
    public function verifyPayment(string $reference): array
    {
        try {
            $tranx = $this->paystack->transaction->verify([
                'reference' => $reference
            ]);

            $payment = Payment::where('payment_reference', $reference)->first();

            if (!$payment) {
                return [
                    'success' => false,
                    'message' => 'Payment record not found'
                ];
            }

            // Update payment based on verification
            if ($tranx->data->status === 'success') {
                $payment->markAsSuccessful($tranx->data);
                $payment->update([
                    'paystack_reference' => $tranx->data->reference,
                    'payment_method' => $tranx->data->channel ?? 'unknown'
                ]);

                return [
                    'success' => true,
                    'data' => $tranx->data,
                    'payment' => $payment,
                    'message' => 'Payment verified successfully'
                ];
            } else {
                $payment->markAsFailed($tranx->data);

                return [
                    'success' => false,
                    'data' => $tranx->data,
                    'payment' => $payment,
                    'message' => 'Payment verification failed'
                ];
            }

        } catch (Exception $e) {
            Log::error('Paystack verification error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Payment verification failed. Please contact support.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Handle webhook events
     */
    public function handleWebhook(array $payload): bool
    {
        try {
            $event = $payload['event'];
            $data = $payload['data'];

            switch ($event) {
                case 'charge.success':
                    return $this->handleSuccessfulCharge($data);

                case 'charge.failed':
                    return $this->handleFailedCharge($data);

                default:
                    Log::info('Unhandled webhook event: ' . $event);
                    return true;
            }

        } catch (Exception $e) {
            Log::error('Webhook handling error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get payment statistics for a zone
     */
    public function getZonePaymentStats(int $zoneId): array
    {
        $payments = Payment::where('zone_id', $zoneId);

        return [
            'total_payments' => $payments->successful()->count(),
            'total_amount' => $payments->successful()->sum('amount'),
            'pending_payments' => $payments->pending()->count(),
            'failed_payments' => $payments->where('status', 'failed')->count(),
            'membership_payments' => $payments->successful()->membership()->sum('amount'),
            'event_payments' => $payments->successful()->event()->sum('amount'),
            'donations' => $payments->successful()->donation()->sum('amount'),
        ];
    }

    /**
     * Get payment statistics for a user
     */
    public function getUserPaymentStats(int $userId): array
    {
        $payments = Payment::where('user_id', $userId);

        return [
            'total_payments' => $payments->successful()->count(),
            'total_amount' => $payments->successful()->sum('amount'),
            'last_payment' => $payments->successful()->latest()->first(),
            'membership_payments' => $payments->successful()->membership()->sum('amount'),
            'event_payments' => $payments->successful()->event()->sum('amount'),
            'donations' => $payments->successful()->donation()->sum('amount'),
        ];
    }

    /**
     * Get default description for payment category
     */
    private function getDefaultDescription(string $category): string
    {
        return match($category) {
            'membership' => 'Monthly membership fee payment',
            'event' => 'Event registration fee',
            'donation' => 'Voluntary donation to FCS Alumni',
            default => 'Payment to FCS Alumni Portal'
        };
    }

    /**
     * Handle successful charge webhook
     */
    private function handleSuccessfulCharge(array $data): bool
    {
        $reference = $data['reference'];
        $payment = Payment::where('payment_reference', $reference)->first();

        if (!$payment) {
            Log::warning('Payment not found for successful charge', ['reference' => $reference]);
            return false;
        }

        $payment->markAsSuccessful($data);

        // Send payment notification
        $notificationService = app(\App\Services\NotificationService::class);
        $notificationService->sendPaymentNotification($payment, true);

        Log::info('Payment marked as successful via webhook', [
            'payment_id' => $payment->id,
            'reference' => $reference,
            'amount' => $payment->amount
        ]);

        return true;
    }

    /**
     * Handle failed charge webhook
     */
    private function handleFailedCharge(array $data): bool
    {
        $reference = $data['reference'];
        $payment = Payment::where('payment_reference', $reference)->first();

        if (!$payment) {
            Log::warning('Payment not found for failed charge', ['reference' => $reference]);
            return false;
        }

        $payment->markAsFailed($data);

        // Send payment notification
        $notificationService = app(\App\Services\NotificationService::class);
        $notificationService->sendPaymentNotification($payment, true);

        Log::info('Payment marked as failed via webhook', [
            'payment_id' => $payment->id,
            'reference' => $reference
        ]);

        return true;
    }

    /**
     * Get public key for frontend
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
}
