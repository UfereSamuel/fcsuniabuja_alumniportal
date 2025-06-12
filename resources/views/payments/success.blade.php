@extends('layouts.app')

@section('title', 'Payment Successful - FCS Alumni Portal')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <i class="fas fa-check text-green-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Payment Successful!</h1>
            <p class="mt-2 text-gray-600">Your payment has been processed successfully</p>
        </div>

        <!-- Payment Details Card -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-green-900">Payment Details</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
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
                            <label class="block text-sm font-medium text-gray-500">Amount Paid</label>
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
                        @if($payment->paystack_reference)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Transaction Reference</label>
                                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->paystack_reference }}</p>
                            </div>
                        @endif

                        @if($payment->payment_method)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Payment Method</label>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Payment Date</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->paid_at ? $payment->paid_at->format('F j, Y g:i A') : $payment->created_at->format('F j, Y g:i A') }}</p>
                        </div>

                        @if($payment->zone)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Zone</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $payment->zone->name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="{{ route('payments.receipt', $payment) }}"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <i class="fas fa-file-pdf mr-2"></i>
                View Receipt
            </a>

            <a href="{{ route('payments.history') }}"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <i class="fas fa-history mr-2"></i>
                Payment History
            </a>

            <a href="{{ route('payments.create') }}"
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <i class="fas fa-plus mr-2"></i>
                Make Another Payment
            </a>
        </div>

        <!-- What's Next -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">What's Next?</h3>
            </div>
            <div class="p-6">
                @if($payment->category === 'membership')
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-900">Membership Active</h4>
                                <p class="mt-1 text-sm text-blue-700">Your membership has been updated. You now have access to all member benefits and activities.</p>
                            </div>
                        </div>
                    </div>
                @elseif($payment->category === 'event')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-check text-green-600"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-green-900">Event Registration Complete</h4>
                                <p class="mt-1 text-sm text-green-700">Your event payment has been confirmed. Check your email for event details and any additional instructions.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-heart text-purple-600"></i>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-purple-900">Thank You for Your Donation</h4>
                                <p class="mt-1 text-sm text-purple-700">Your generous contribution helps support FCS Alumni activities and community initiatives.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <!-- Email Confirmation -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-envelope text-gray-600 text-xl mb-2"></i>
                        <h4 class="text-sm font-medium text-gray-900">Email Confirmation</h4>
                        <p class="text-xs text-gray-600 mt-1">A receipt has been sent to your email address</p>
                    </div>

                    <!-- Dashboard Update -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-tachometer-alt text-gray-600 text-xl mb-2"></i>
                        <h4 class="text-sm font-medium text-gray-900">Dashboard Updated</h4>
                        <p class="text-xs text-gray-600 mt-1">Your payment history has been updated</p>
                    </div>

                    <!-- Support Available -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-headset text-gray-600 text-xl mb-2"></i>
                        <h4 class="text-sm font-medium text-gray-900">Support Available</h4>
                        <p class="text-xs text-gray-600 mt-1">Contact us if you have any questions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Return to Dashboard -->
        <div class="text-center mt-8">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">
                <i class="fas fa-arrow-left mr-2"></i>
                Return to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
