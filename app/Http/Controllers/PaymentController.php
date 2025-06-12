<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Zone;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->middleware('auth');
        $this->paystackService = $paystackService;
    }

    /**
     * Show payment form
     */
    public function index()
    {
        $user = Auth::user();
        $paymentStats = $this->paystackService->getUserPaymentStats($user->id);
        $recentPayments = Payment::where('user_id', $user->id)
                                ->with('zone')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('payments.index', compact('user', 'paymentStats', 'recentPayments'));
    }

    /**
     * Show payment form for specific category
     */
    public function create(Request $request)
    {
        $category = $request->get('category', 'membership');
        $user = Auth::user();

        if (!$user->hasZone()) {
            return redirect()->route('profile.edit')
                           ->with('error', 'Please select a zone before making payments.');
        }

        $publicKey = $this->paystackService->getPublicKey();

        return view('payments.create', compact('category', 'user', 'publicKey'));
    }

    /**
     * Initialize payment
     */
    public function initialize(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100|max:1000000',
            'category' => 'required|in:membership,event,donation',
            'description' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        if (!$user->hasZone()) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a zone before making payments.'
            ], 400);
        }

        $result = $this->paystackService->initializePayment(
            $user,
            $request->amount,
            $request->category,
            $request->description
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'authorization_url' => $result['authorization_url'],
                'reference' => $result['reference'],
                'message' => 'Payment initialized successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 400);
    }

    /**
     * Handle payment callback
     */
    public function callback(Request $request)
    {
        $reference = $request->get('reference');

        if (!$reference) {
            return redirect()->route('payments.index')
                           ->with('error', 'Invalid payment reference');
        }

        $result = $this->paystackService->verifyPayment($reference);

        if ($result['success']) {
            return redirect()->route('payments.success', ['reference' => $reference])
                           ->with('success', 'Payment completed successfully!');
        }

        return redirect()->route('payments.failed', ['reference' => $reference])
                       ->with('error', 'Payment verification failed');
    }

    /**
     * Payment success page
     */
    public function success(Request $request)
    {
        $reference = $request->get('reference');
        $payment = Payment::where('payment_reference', $reference)
                         ->where('user_id', Auth::id())
                         ->first();

        if (!$payment) {
            return redirect()->route('payments.index')
                           ->with('error', 'Payment not found');
        }

        return view('payments.success', compact('payment'));
    }

    /**
     * Payment failed page
     */
    public function failed(Request $request)
    {
        $reference = $request->get('reference');
        $payment = Payment::where('payment_reference', $reference)
                         ->where('user_id', Auth::id())
                         ->first();

        return view('payments.failed', compact('payment'));
    }

    /**
     * Payment history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $query = Payment::where('user_id', $user->id)->with('zone');

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $payments = $query->latest()->paginate(15);
        $paymentStats = $this->paystackService->getUserPaymentStats($user->id);

        return view('payments.history', compact('payments', 'paymentStats'));
    }

    /**
     * Handle webhook
     */
    public function webhook(Request $request)
    {
        // Verify the webhook is from Paystack
        $signature = $request->header('X-Paystack-Signature');
        $body = $request->getContent();

        if ($signature !== hash_hmac('sha512', $body, config('services.paystack.secret_key'))) {
            Log::warning('Invalid webhook signature');
            return response('Unauthorized', 401);
        }

        $payload = json_decode($body, true);

        $result = $this->paystackService->handleWebhook($payload);

        if ($result) {
            return response('Webhook handled successfully', 200);
        }

        return response('Webhook handling failed', 500);
    }

    /**
     * Get payment receipt
     */
    public function receipt(Payment $payment)
    {
        // Ensure user can only access their own payments
        if ($payment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to payment receipt');
        }

        return view('payments.receipt', compact('payment'));
    }

    /**
     * Download payment receipt as PDF
     */
    public function downloadReceipt(Payment $payment)
    {
        // Ensure user can only access their own payments
        if ($payment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to payment receipt');
        }

        // This would require a PDF generation library like dompdf
        // For now, we'll redirect to the receipt view
        return redirect()->route('payments.receipt', $payment);
    }
}
