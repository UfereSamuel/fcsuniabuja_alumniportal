@extends('layouts.app')

@section('title', 'Payment Failed - FCS Alumni Portal')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Error Header -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <i class="fas fa-times text-red-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Payment Failed</h1>
            <p class="mt-2 text-gray-600">Unfortunately, your payment could not be processed</p>
        </div>

        @if($payment)
            <!-- Payment Details Card -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-8">
                <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-red-900">Payment Details</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i>
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Payment Information -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Payment Reference</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->payment_reference }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Amount</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">₦{{ number_format($payment->amount, 2) }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Payment Category</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($payment->category === 'membership') bg-blue-100 text-blue-800
                                        @elseif($payment->category === 'event') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ ucfirst($payment->category) }}
                                    </span>
                                </p>
                            </div>

                            @if($payment->description)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Description</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $payment->description }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Transaction Information -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Attempt Date</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->created_at->format('F j, Y g:i A') }}</p>
                            </div>

                            @if($payment->zone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Zone</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $payment->zone->name }}</p>
                                </div>
                            @endif

                            @if($payment->paystack_response && isset($payment->paystack_response['gateway_response']))
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Error Details</label>
                                    <p class="mt-1 text-sm text-red-600">{{ $payment->paystack_response['gateway_response'] }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Common Issues Section -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Common Issues & Solutions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Insufficient Funds -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-credit-card text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-gray-900">Insufficient Funds</h4>
                            <p class="mt-1 text-sm text-gray-600">Ensure your account has sufficient balance or credit limit to complete the payment.</p>
                        </div>
                    </div>

                    <!-- Card Issues -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-ban text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-gray-900">Card Declined</h4>
                            <p class="mt-1 text-sm text-gray-600">Your card may have been declined by your bank. Try a different card or contact your bank.</p>
                        </div>
                    </div>

                    <!-- Network Issues -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-wifi text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-gray-900">Connection Issues</h4>
                            <p class="mt-1 text-sm text-gray-600">Poor internet connection can cause payment failures. Ensure you have a stable connection.</p>
                        </div>
                    </div>

                    <!-- Expired Card -->
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-times text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-gray-900">Expired Card</h4>
                            <p class="mt-1 text-sm text-gray-600">Check that your card hasn't expired and that the details entered are correct.</p>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shield-alt text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-yellow-900">Security Notice</h4>
                            <p class="mt-1 text-sm text-yellow-700">
                                For your security, no payment has been charged to your account.
                                You can safely retry the payment or use a different payment method.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            @if($payment)
                <a href="{{ route('payments.create', ['category' => $payment->category, 'amount' => $payment->amount]) }}"
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-redo mr-2"></i>
                    Retry Payment
                </a>
            @else
                <a href="{{ route('payments.create') }}"
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    <i class="fas fa-redo mr-2"></i>
                    Try Again
                </a>
            @endif

            <a href="{{ route('payments.history') }}"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <i class="fas fa-history mr-2"></i>
                Payment History
            </a>

            <a href="mailto:support@fcsalumni.com"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <i class="fas fa-envelope mr-2"></i>
                Contact Support
            </a>
        </div>

        <!-- Alternative Payment Methods -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Try Alternative Payment Methods</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    If your card payment failed, try one of these alternative payment methods available through Paystack:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Bank Transfer -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-university text-blue-600 text-2xl mb-2"></i>
                        <h4 class="text-sm font-medium text-gray-900">Bank Transfer</h4>
                        <p class="text-xs text-gray-600 mt-1">Transfer directly from your bank account</p>
                    </div>

                    <!-- USSD -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-mobile-alt text-green-600 text-2xl mb-2"></i>
                        <h4 class="text-sm font-medium text-gray-900">USSD</h4>
                        <p class="text-xs text-gray-600 mt-1">Pay using your mobile phone</p>
                    </div>

                    <!-- Different Card -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-credit-card text-purple-600 text-2xl mb-2"></i>
                        <h4 class="text-sm font-medium text-gray-900">Different Card</h4>
                        <p class="text-xs text-gray-600 mt-1">Try with another debit/credit card</p>
                    </div>

                    <!-- QR Code -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-qrcode text-orange-600 text-2xl mb-2"></i>
                        <h4 class="text-sm font-medium text-gray-900">QR Code</h4>
                        <p class="text-xs text-gray-600 mt-1">Scan and pay with your banking app</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Information -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-900">Need Help?</h4>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>If you continue to experience issues with your payment, please contact our support team:</p>
                        <ul class="mt-2 space-y-1">
                            <li>• Email: <a href="mailto:support@fcsalumni.com" class="font-medium underline">support@fcsalumni.com</a></li>
                            <li>• Include your payment reference: <span class="font-mono">{{ $payment ? $payment->payment_reference : 'N/A' }}</span></li>
                            <li>• Describe the issue you encountered</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Return to Dashboard -->
        <div class="text-center">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
