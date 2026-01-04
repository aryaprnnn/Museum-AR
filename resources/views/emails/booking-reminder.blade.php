<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Reminder</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #000000;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 400;
            letter-spacing: 0.05em;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
        }
        .content h2 {
            color: #000000;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .content p {
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .booking-info {
            background-color: #f9f9f9;
            border-left: 4px solid #000000;
            padding: 20px;
            margin: 25px 0;
        }
        .booking-info h3 {
            margin-top: 0;
            color: #000000;
            font-size: 18px;
        }
        .booking-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .booking-info table td {
            padding: 8px 0;
            vertical-align: top;
        }
        .booking-info table td:first-child {
            font-weight: 600;
            width: 140px;
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: 600;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #888888;
        }
        .reminder-badge {
            display: inline-block;
            background-color: #00897B;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        /* Payment status styles to avoid inline Blade in style attributes */
        .status-paid {
            color: #00897B;
            font-weight: 600;
        }
        .status-pending {
            color: #ff9800;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>ARtifact Museum</h1>
        </div>
        
        <div class="content">
            <span class="reminder-badge">📅 REMINDER</span>
            
            <h2>Hello, {{ $booking->participant_name }}!</h2>
            
            <p>This is a friendly reminder about your upcoming booking with us at ARtifact Museum.</p>
            
            <div class="booking-info">
                <h3>📌 Booking Details</h3>
                <table>
                    <tr>
                        <td>Booking Code:</td>
                        <td><strong>{{ $booking->booking_code }}</strong></td>
                    </tr>
                    <tr>
                        <td>Program/Class:</td>
                        <td><strong>{{ $bookingDetails->title }}</strong></td>
                    </tr>
                    @if($booking->event_date)
                    <tr>
                        <td>Event Date:</td>
                        <td><strong>{{ \Carbon\Carbon::parse($booking->event_date)->format('l, F j, Y') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Time:</td>
                        <td><strong>{{ \Carbon\Carbon::parse($booking->event_date)->format('h:i A') }}</strong></td>
                    </tr>
                    @endif
                    @if(isset($bookingDetails->schedule))
                    <tr>
                        <td>Schedule:</td>
                        <td>{{ $bookingDetails->schedule }}</td>
                    </tr>
                    @endif
                    @if($booking->institution)
                    <tr>
                        <td>Institution:</td>
                        <td>{{ $booking->institution }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Payment Status:</td>
                        <td>
                            <span class="{{ $booking->payment_status == 'paid' ? 'status-paid' : 'status-pending' }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            
            @if($booking->payment_status !== 'paid')
            <p style="color: #d32f2f; font-weight: 600;">⚠️ Please note: Your payment is still <strong>{{ $booking->payment_status }}</strong>. Please complete your payment to confirm your booking.</p>
            @endif
            
            <p>We're looking forward to seeing you! If you have any questions or need to make changes to your booking, please don't hesitate to contact us.</p>
            
            <center>
                <a
                    href="{{
                        ($booking->bookable_type === \App\Models\ArtClass::class && isset($bookingDetails->slug))
                            ? route('artclass.show', $bookingDetails->slug)
                            : (
                                ($booking->bookable_type === \App\Models\EducationalProgram::class && isset($bookingDetails->slug))
                                    ? route('educational-program.show', $bookingDetails->slug)
                                    : route('user.bookings', ['highlight' => $booking->booking_code])
                              )
                    }}"
                    class="btn"
                >
                    {{
                        ($booking->bookable_type === \App\Models\ArtClass::class && isset($bookingDetails->slug)) ||
                        ($booking->bookable_type === \App\Models\EducationalProgram::class && isset($bookingDetails->slug))
                            ? 'View Detail'
                            : 'View My Bookings'
                    }}
                </a>
            </center>
        </div>
        
        <div class="footer">
            <p>ARtifact Museum | Preserving Culture Through Innovation</p>
            <p>This is an automated reminder email. Please do not reply to this email.</p>
            <p>If you have questions, please contact us at <a href="mailto:info@artifactmuseum.com">info@artifactmuseum.com</a></p>
        </div>
    </div>
</body>
</html>
