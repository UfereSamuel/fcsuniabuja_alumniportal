<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $notification->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header .subtitle {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px 20px;
        }
        .notification-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .notification-badge.payment {
            background-color: #dcfce7;
            color: #166534;
        }
        .notification-badge.zone_update {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .notification-badge.event {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        .notification-badge.system {
            background-color: #f3f4f6;
            color: #374151;
        }
        .message-title {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin: 0 0 15px 0;
        }
        .message-content {
            font-size: 16px;
            line-height: 1.6;
            color: #4b5563;
            margin-bottom: 25px;
        }
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            margin: 10px 0;
        }
        .action-button:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        }
        .details-section {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }
        .details-title {
            font-weight: bold;
            color: #1f2937;
            margin: 0 0 10px 0;
        }
        .details-item {
            margin: 8px 0;
            font-size: 14px;
        }
        .details-label {
            font-weight: bold;
            color: #6b7280;
            display: inline-block;
            width: 100px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
            font-size: 12px;
            color: #6b7280;
        }
        .priority-urgent {
            border-left-color: #dc2626 !important;
        }
        .priority-high {
            border-left-color: #f59e0b !important;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .header, .content {
                padding: 20px 15px;
            }
            .message-title {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>FCS Alumni Portal</h1>
            <p class="subtitle">Federal College of Science Alumni Association</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Notification Type Badge -->
            <div class="notification-badge {{ $notification->type }}">
                <i class="{{ $notification->notification_icon }}"></i> {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
            </div>

            <!-- Message -->
            <h2 class="message-title">{{ $notification->title }}</h2>
            <div class="message-content">
                {{ $notification->message }}
            </div>

            <!-- Action Button -->
            @if($notification->action_url)
                <a href="{{ $notification->action_url }}" class="action-button">
                    View Details
                </a>
            @endif

            <!-- Details Section -->
            <div class="details-section @if($notification->priority === 'urgent') priority-urgent @elseif($notification->priority === 'high') priority-high @endif">
                <div class="details-title">Notification Details</div>

                <div class="details-item">
                    <span class="details-label">Type:</span>
                    {{ ucfirst(str_replace('_', ' ', $notification->type)) }}
                </div>

                <div class="details-item">
                    <span class="details-label">Priority:</span>
                    {{ ucfirst($notification->priority) }}
                </div>

                <div class="details-item">
                    <span class="details-label">Date:</span>
                    {{ $notification->created_at->format('F j, Y g:i A') }}
                </div>

                @if($notification->zone)
                    <div class="details-item">
                        <span class="details-label">Zone:</span>
                        {{ $notification->zone->name }}
                    </div>
                @endif

                @if($notification->data && is_array($notification->data))
                    @foreach($notification->data as $key => $value)
                        @if(is_string($value) || is_numeric($value))
                            <div class="details-item">
                                <span class="details-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                {{ $value }}
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>

            <!-- Additional Info for Payment Notifications -->
            @if($notification->type === 'payment' && $notification->data)
                <div class="details-section">
                    <div class="details-title">Payment Information</div>

                    @if(isset($notification->data['amount']))
                        <div class="details-item">
                            <span class="details-label">Amount:</span>
                            ₦{{ number_format($notification->data['amount'], 2) }}
                        </div>
                    @endif

                    @if(isset($notification->data['category']))
                        <div class="details-item">
                            <span class="details-label">Category:</span>
                            {{ ucfirst($notification->data['category']) }}
                        </div>
                    @endif

                    @if(isset($notification->data['payment_reference']))
                        <div class="details-item">
                            <span class="details-label">Reference:</span>
                            {{ $notification->data['payment_reference'] }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Federal College of Science Alumni Portal</strong></p>
            <p>This email was sent automatically. Please do not reply to this email.</p>
            <p>If you have questions, please contact us through the alumni portal.</p>
            <p style="margin-top: 15px;">
                <a href="{{ route('dashboard') }}" style="color: #3b82f6; text-decoration: none;">Visit Alumni Portal</a>
            </p>
        </div>
    </div>
</body>
</html>
