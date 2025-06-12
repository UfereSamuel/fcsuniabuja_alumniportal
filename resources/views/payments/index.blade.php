@extends('layouts.app')

@section('title', 'Payments - FCS Alumni Portal')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Payment Center</h1>
            <p class="mt-2 text-gray-600">Manage your payments and view payment history</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Payments -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-credit-card text-blue-600"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Payments</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $paymentStats['total_payments'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-naira-sign text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Amount</dt>
                                <dd class="text-lg font-medium text-gray-900">₦{{ number_format($paymentStats['total_amount'], 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Successful Payments -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Successful</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $paymentStats['successful_payments'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Payments -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $paymentStats['pending_payments'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Categories Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Membership Payments -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Membership Payments</p>
                            <p class="text-2xl font-bold text-blue-600">₦{{ number_format($paymentStats['membership_payments'], 2) }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Payments -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Event Payments</p>
                            <p class="text-2xl font-bold text-green-600">₦{{ number_format($paymentStats['event_payments'], 2) }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donations -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Donations</p>
                            <p class="text-2xl font-bold text-purple-600">₦{{ number_format($paymentStats['donations'], 2) }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-heart text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Make Payment -->
                    <a href="{{ route('payments.create') }}"
                       class="flex flex-col items-center p-6 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition group">
                        <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-3 group-hover:bg-blue-700 transition">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-blue-900">Make Payment</h4>
                        <p class="text-xs text-blue-700 text-center mt-1">Start a new payment transaction</p>
                    </a>

                    <!-- View History -->
                    <a href="{{ route('payments.history') }}"
                       class="flex flex-col items-center p-6 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition group">
                        <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-3 group-hover:bg-green-700 transition">
                            <i class="fas fa-history text-white text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-green-900">Payment History</h4>
                        <p class="text-xs text-green-700 text-center mt-1">View all your transactions</p>
                    </a>

                    <!-- Membership Fee -->
                    <a href="{{ route('payments.create', ['category' => 'membership']) }}"
                       class="flex flex-col items-center p-6 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition group">
                        <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-3 group-hover:bg-purple-700 transition">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-purple-900">Membership Fee</h4>
                        <p class="text-xs text-purple-700 text-center mt-1">Pay your membership dues</p>
                    </a>

                    <!-- Make Donation -->
                    <a href="{{ route('payments.create', ['category' => 'donation']) }}"
                       class="flex flex-col items-center p-6 bg-orange-50 border border-orange-200 rounded-lg hover:bg-orange-100 transition group">
                        <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mb-3 group-hover:bg-orange-700 transition">
                            <i class="fas fa-heart text-white text-xl"></i>
                        </div>
                        <h4 class="text-sm font-medium text-orange-900">Make Donation</h4>
                        <p class="text-xs text-orange-700 text-center mt-1">Support FCS activities</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Recent Payments</h3>
                <a href="{{ route('payments.history') }}"
                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentPayments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentPayments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $payment->payment_reference }}</div>
                                        @if($payment->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($payment->description, 30) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($payment->category === 'membership') bg-blue-100 text-blue-800
                                            @elseif($payment->category === 'event') bg-green-100 text-green-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            {{ ucfirst($payment->category) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                        ₦{{ number_format($payment->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($payment->status === 'successful') bg-green-100 text-green-800
                                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($payment->status === 'successful')
                                                <i class="fas fa-check mr-1"></i>
                                            @elseif($payment->status === 'pending')
                                                <i class="fas fa-clock mr-1"></i>
                                            @else
                                                <i class="fas fa-times mr-1"></i>
                                            @endif
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $payment->created_at->format('M j, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->created_at->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            @if($payment->status === 'successful')
                                                <a href="{{ route('payments.receipt', $payment) }}"
                                                   class="text-blue-600 hover:text-blue-900" title="View Receipt">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @elseif($payment->status === 'failed')
                                                <a href="{{ route('payments.create', ['category' => $payment->category, 'amount' => $payment->amount]) }}"
                                                   class="text-green-600 hover:text-green-900" title="Retry Payment">
                                                    <i class="fas fa-redo"></i>
                                                </a>
                                            @else
                                                <span class="text-yellow-600" title="Processing">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-credit-card text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No payments yet</h3>
                    <p class="text-gray-600 mb-4">You haven't made any payments yet. Get started by making your first payment.</p>
                    <a href="{{ route('payments.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i>Make Your First Payment
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
