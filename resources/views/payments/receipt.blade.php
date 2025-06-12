@extends('layouts.app')

@section('title', 'Payment Receipt - FCS Alumni Portal')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('payments.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-credit-card mr-2"></i>Payments
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400"></i>
                            <a href="{{ route('payments.history') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Payment History</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Receipt</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex justify-between items-start mt-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Payment Receipt</h1>
                    <p class="mt-2 text-gray-600">Reference: {{ $payment->payment_reference }}</p>
                </div>
                <div class="flex space-x-3 print:hidden">
                    <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        <i class="fas fa-print mr-2"></i>Print Receipt
                    </button>
                    <a href="{{ route('payments.history') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back to History
                    </a>
                </div>
            </div>
        </div>

        <!-- Receipt Card -->
        <div class="bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden" id="receipt">
            <!-- Receipt Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/logos/fcslogo.png') }}" alt="FCS Logo" class="w-12 h-12">
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">FCS Alumni Portal</h2>
                            <p class="text-blue-100">Fellowship of Christian Students</p>
                            <p class="text-blue-100 text-sm">University of Abuja</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold">RECEIPT</div>
                        <div class="text-blue-100 text-sm">{{ $payment->created_at->format('F j, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Receipt Content -->
            <div class="px-8 py-6">
                <!-- Success Status -->
                @if($payment->status === 'successful')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-900">Payment Confirmed</h3>
                                <p class="text-sm text-green-700">This payment has been successfully processed and confirmed.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Payment Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Payer Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Payer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                <p class="text-sm text-gray-900">{{ $payment->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                <p class="text-sm text-gray-900">{{ $payment->user->email }}</p>
                            </div>
                            @if($payment->user->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                                    <p class="text-sm text-gray-900">{{ $payment->user->phone }}</p>
                                </div>
                            @endif
                            @if($payment->zone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Zone</label>
                                    <p class="text-sm text-gray-900">{{ $payment->zone->name }}</p>
                                </div>
                            @endif
                            @if($payment->user->class)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Graduation Class</label>
                                    <p class="text-sm text-gray-900">{{ $payment->user->class->full_name }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Payment Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Payment Reference</label>
                                <p class="text-sm text-gray-900 font-mono">{{ $payment->payment_reference }}</p>
                            </div>
                            @if($payment->paystack_reference)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Transaction Reference</label>
                                    <p class="text-sm text-gray-900 font-mono">{{ $payment->paystack_reference }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Payment Category</label>
                                <p class="text-sm text-gray-900">
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
                                    <p class="text-sm text-gray-900">{{ $payment->description }}</p>
                                </div>
                            @endif
                            @if($payment->payment_method)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Payment Method</label>
                                    <p class="text-sm text-gray-900">{{ ucfirst($payment->payment_method) }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Payment Date</label>
                                <p class="text-sm text-gray-900">{{ $payment->paid_at ? $payment->paid_at->format('F j, Y g:i A') : $payment->created_at->format('F j, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Amount Summary -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">{{ ucfirst($payment->category) }} Payment</span>
                                <span class="text-sm text-gray-900">₦{{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Processing Fee</span>
                                <span class="text-sm text-gray-900">₦0.00</span>
                            </div>
                            <div class="border-t border-gray-300 pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total Amount Paid</span>
                                    <span class="text-2xl font-bold text-gray-900">₦{{ number_format($payment->amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization Information -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p><i class="fas fa-envelope w-4"></i> admin@fcsalumni.com</p>
                                <p><i class="fas fa-globe w-4"></i> www.fcsalumni.com</p>
                                <p><i class="fas fa-map-marker-alt w-4"></i> University of Abuja, FCT, Nigeria</p>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Important Notes</h3>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p>• This receipt serves as proof of payment</p>
                                <p>• Keep this receipt for your records</p>
                                <p>• For inquiries, contact support with reference number</p>
                                <p>• Payment processed securely via Paystack</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="border-t border-gray-200 pt-6 mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        This is an automatically generated receipt. No signature required.<br>
                        Generated on {{ now()->format('F j, Y g:i A') }} | Receipt ID: {{ $payment->id }}
                    </p>
                    <div class="mt-4 text-xs text-gray-400">
                        Fellowship of Christian Students Alumni Portal © {{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions (Print Hidden) -->
        <div class="mt-8 flex justify-center space-x-4 print:hidden">
            <a href="{{ route('payments.create') }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                <i class="fas fa-plus mr-2"></i>Make Another Payment
            </a>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                <i class="fas fa-home mr-2"></i>Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    body * {
        visibility: hidden;
    }

    #receipt, #receipt * {
        visibility: visible;
    }

    #receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        border: none !important;
    }

    .print\\:hidden {
        display: none !important;
    }

    .bg-gradient-to-r {
        background: #2563eb !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    .bg-green-50, .bg-gray-50 {
        background: #f9fafb !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    .border {
        border: 1px solid #e5e7eb !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
}
</style>
@endsection
