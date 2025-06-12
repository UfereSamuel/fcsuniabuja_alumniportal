@extends('layouts.app')

@section('title', 'Make Payment - FCS Alumni Portal')

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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Make Payment</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 mt-4">Make Payment</h1>
            <p class="mt-2 text-gray-600">Complete your payment securely using Paystack</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Payment Form -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Payment Details</h2>
                        <p class="text-sm text-gray-500 mt-1">Enter your payment information below</p>
                    </div>

                    <form id="payment-form" class="p-6 space-y-6">
                        @csrf

                        <!-- Category Selection -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Payment Category</label>
                            <select name="category" id="category" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select payment category</option>
                                <option value="membership" {{ $category === 'membership' ? 'selected' : '' }}>Membership Fee</option>
                                <option value="event" {{ $category === 'event' ? 'selected' : '' }}>Event Payment</option>
                                <option value="donation" {{ $category === 'donation' ? 'selected' : '' }}>Donation</option>
                            </select>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount (₦)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₦</span>
                                </div>
                                <input type="number" name="amount" id="amount" step="0.01" min="100" max="1000000" required
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="0.00">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Minimum amount: ₦100.00</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Add a note about this payment..."></textarea>
                        </div>

                        <!-- Payment Summary -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-3">Payment Summary</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Category:</span>
                                    <span id="summary-category" class="font-medium text-gray-900">-</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Amount:</span>
                                    <span id="summary-amount" class="font-medium text-gray-900">₦0.00</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-900">Total:</span>
                                        <span id="summary-total" class="font-medium text-gray-900">₦0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="pay-button" disabled
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            <span id="pay-button-text">
                                <i class="fas fa-lock mr-2"></i>Proceed to Payment
                            </span>
                            <span id="pay-button-loading" class="hidden">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Info Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>

                    <!-- User Info -->
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-user text-gray-400 w-5"></i>
                            <span class="ml-3 text-sm text-gray-900">{{ $user->name }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 w-5"></i>
                            <span class="ml-3 text-sm text-gray-900">{{ $user->email }}</span>
                        </div>
                        @if($user->zone)
                            <div class="flex items-center">
                                <i class="fas fa-globe-africa text-gray-400 w-5"></i>
                                <span class="ml-3 text-sm text-gray-900">{{ $user->zone->name }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Security Info -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="font-medium text-gray-900 mb-3">Secure Payment</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-green-600 w-5"></i>
                                <span class="ml-3 text-sm text-gray-600">SSL Encrypted</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-lock text-green-600 w-5"></i>
                                <span class="ml-3 text-sm text-gray-600">Paystack Secured</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-credit-card text-green-600 w-5"></i>
                                <span class="ml-3 text-sm text-gray-600">Card Details Protected</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="font-medium text-gray-900 mb-3">Accepted Payment Methods</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-gray-50 p-2 rounded text-center">
                                <i class="fab fa-cc-visa text-blue-600 text-xl"></i>
                            </div>
                            <div class="bg-gray-50 p-2 rounded text-center">
                                <i class="fab fa-cc-mastercard text-red-600 text-xl"></i>
                            </div>
                            <div class="bg-gray-50 p-2 rounded text-center">
                                <span class="text-xs font-medium text-gray-700">Bank Transfer</span>
                            </div>
                            <div class="bg-gray-50 p-2 rounded text-center">
                                <span class="text-xs font-medium text-gray-700">USSD</span>
                            </div>
                        </div>
                    </div>

                    <!-- Support -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="font-medium text-gray-900 mb-3">Need Help?</h4>
                        <p class="text-sm text-gray-600 mb-3">Contact our support team if you encounter any issues with your payment.</p>
                        <a href="mailto:support@fcsalumni.com" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            <i class="fas fa-envelope mr-1"></i>support@fcsalumni.com
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="error-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Payment Error</h3>
            <div class="mt-2 px-7 py-3">
                <p id="error-message" class="text-sm text-gray-500"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="close-error-modal" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('payment-form');
    const categorySelect = document.getElementById('category');
    const amountInput = document.getElementById('amount');
    const payButton = document.getElementById('pay-button');
    const payButtonText = document.getElementById('pay-button-text');
    const payButtonLoading = document.getElementById('pay-button-loading');

    // Summary elements
    const summaryCategory = document.getElementById('summary-category');
    const summaryAmount = document.getElementById('summary-amount');
    const summaryTotal = document.getElementById('summary-total');

    // Error modal elements
    const errorModal = document.getElementById('error-modal');
    const errorMessage = document.getElementById('error-message');
    const closeErrorModal = document.getElementById('close-error-modal');

    // Update payment summary
    function updateSummary() {
        const category = categorySelect.value;
        const amount = parseFloat(amountInput.value) || 0;

        summaryCategory.textContent = category ? category.charAt(0).toUpperCase() + category.slice(1) : '-';
        summaryAmount.textContent = `₦${amount.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`;
        summaryTotal.textContent = `₦${amount.toLocaleString('en-NG', { minimumFractionDigits: 2 })}`;

        // Enable/disable pay button
        payButton.disabled = !category || amount < 100;
    }

    // Event listeners
    categorySelect.addEventListener('change', updateSummary);
    amountInput.addEventListener('input', updateSummary);

    // Close error modal
    closeErrorModal.addEventListener('click', function() {
        errorModal.classList.add('hidden');
    });

    // Show error modal
    function showError(message) {
        errorMessage.textContent = message;
        errorModal.classList.remove('hidden');
    }

    // Set loading state
    function setLoading(loading) {
        if (loading) {
            payButtonText.classList.add('hidden');
            payButtonLoading.classList.remove('hidden');
            payButton.disabled = true;
        } else {
            payButtonText.classList.remove('hidden');
            payButtonLoading.classList.add('hidden');
            updateSummary(); // This will properly set the disabled state
        }
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        setLoading(true);

        // Initialize payment with backend
        fetch('{{ route("payments.initialize") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            setLoading(false);

            if (data.success) {
                // Initialize Paystack payment
                const handler = PaystackPop.setup({
                    key: '{{ $publicKey }}',
                    email: '{{ $user->email }}',
                    amount: Math.round(parseFloat(amountInput.value) * 100), // Convert to kobo
                    currency: 'NGN',
                    ref: data.reference,
                    metadata: {
                        custom_fields: [
                            {
                                display_name: "User Name",
                                variable_name: "user_name",
                                value: "{{ $user->name }}"
                            },
                            {
                                display_name: "Payment Category",
                                variable_name: "category",
                                value: categorySelect.value
                            }
                        ]
                    },
                    callback: function(response) {
                        // Payment successful, redirect to callback
                        window.location.href = '{{ route("payments.callback") }}?reference=' + response.reference;
                    },
                    onClose: function() {
                        // Payment window closed
                        console.log('Payment window closed');
                    }
                });

                handler.openIframe();
            } else {
                showError(data.message || 'Failed to initialize payment. Please try again.');
            }
        })
        .catch(error => {
            setLoading(false);
            console.error('Error:', error);
            showError('An error occurred while processing your request. Please try again.');
        });
    });

    // Initial summary update
    updateSummary();
});
</script>
@endsection
