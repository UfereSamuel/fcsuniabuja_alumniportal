<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Zone;
use App\Models\User;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'zone']);

        // Filter by zone
        if ($request->has('zone_id') && $request->zone_id !== 'all') {
            $query->where('zone_id', $request->zone_id);
        }

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

        // Search by user name or email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $payments = $query->latest()->paginate(20);

        // Get statistics
        $stats = [
            'total_payments' => Payment::successful()->count(),
            'total_amount' => Payment::successful()->sum('amount'),
            'pending_payments' => Payment::pending()->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'membership_revenue' => Payment::successful()->membership()->sum('amount'),
            'event_revenue' => Payment::successful()->event()->sum('amount'),
            'donation_revenue' => Payment::successful()->donation()->sum('amount'),
        ];

        $zones = Zone::active()->orderBy('name')->get();

        return view('admin.payments.index', compact('payments', 'stats', 'zones'));
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load(['user', 'zone']);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Get payment analytics
     */
    public function analytics(Request $request)
    {
        $period = $request->get('period', '30'); // days

        // Payment trends over time
        $paymentTrends = Payment::successful()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount) as total')
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Payment by category
        $categoryStats = Payment::successful()
            ->selectRaw('category, COUNT(*) as count, SUM(amount) as total')
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('category')
            ->get();

        // Payment by zone
        $zoneStats = Payment::successful()
            ->with('zone')
            ->selectRaw('zone_id, COUNT(*) as count, SUM(amount) as total')
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('zone_id')
            ->get();

        // Top paying users
        $topUsers = Payment::successful()
            ->with('user')
            ->selectRaw('user_id, COUNT(*) as payment_count, SUM(amount) as total_amount')
            ->where('created_at', '>=', now()->subDays($period))
            ->groupBy('user_id')
            ->orderBy('total_amount', 'desc')
            ->take(10)
            ->get();

        return view('admin.payments.analytics', compact(
            'paymentTrends',
            'categoryStats',
            'zoneStats',
            'topUsers',
            'period'
        ));
    }

    /**
     * Export payments to CSV
     */
    public function export(Request $request)
    {
        $query = Payment::with(['user', 'zone']);

        // Apply same filters as index
        if ($request->has('zone_id') && $request->zone_id !== 'all') {
            $query->where('zone_id', $request->zone_id);
        }

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $payments = $query->latest()->get();

        $filename = 'payments_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'ID',
                'User Name',
                'User Email',
                'Zone',
                'Amount',
                'Category',
                'Status',
                'Payment Method',
                'Reference',
                'Description',
                'Created At',
                'Paid At'
            ]);

            // Data rows
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->user->name ?? 'N/A',
                    $payment->user->email ?? 'N/A',
                    $payment->zone->name ?? 'N/A',
                    $payment->amount,
                    ucfirst($payment->category),
                    ucfirst($payment->status),
                    $payment->payment_method ?? 'N/A',
                    $payment->payment_reference,
                    $payment->description ?? 'N/A',
                    $payment->created_at->format('Y-m-d H:i:s'),
                    $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get zone payment summary
     */
    public function zoneSummary(Request $request)
    {
        $zones = Zone::with(['payments' => function($query) use ($request) {
            if ($request->has('from_date') && $request->from_date) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }
            if ($request->has('to_date') && $request->to_date) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }
        }])->get();

        $zoneSummary = $zones->map(function($zone) {
            $stats = $this->paystackService->getZonePaymentStats($zone->id);
            return [
                'zone' => $zone,
                'stats' => $stats
            ];
        });

        return view('admin.payments.zone-summary', compact('zoneSummary'));
    }

    /**
     * Refund payment (if supported by payment gateway)
     */
    public function refund(Payment $payment)
    {
        // This would implement refund logic
        // For now, we'll just mark it as refunded in our system

        if ($payment->status !== 'successful') {
            return back()->with('error', 'Only successful payments can be refunded.');
        }

        // Here you would integrate with Paystack refund API
        // For now, we'll just update the status
        $payment->update(['status' => 'refunded']);

        return back()->with('success', 'Payment marked as refunded.');
    }

    /**
     * Manually verify payment
     */
    public function verify(Payment $payment)
    {
        if ($payment->status === 'successful') {
            return back()->with('info', 'Payment is already verified.');
        }

        $result = $this->paystackService->verifyPayment($payment->payment_reference);

        if ($result['success']) {
            return back()->with('success', 'Payment verified successfully.');
        }

        return back()->with('error', 'Payment verification failed: ' . $result['message']);
    }
}
