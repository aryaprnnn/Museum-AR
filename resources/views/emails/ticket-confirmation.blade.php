<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Confirmation</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        .header { background-color: #000000; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 400; letter-spacing: 0.05em; }
        .success-badge { background-color: #00897B; color: white; padding: 40px; text-align: center; }
        .success-badge .icon { font-size: 48px; margin-bottom: 10px; }
        .success-badge h2 { margin: 0; font-size: 22px; font-weight: 600; }
        .content { padding: 40px 30px; color: #333333; }
        .content p { line-height: 1.6; margin-bottom: 15px; }
        .booking-info { background-color: #f9f9f9; border-left: 4px solid #000000; padding: 20px; margin: 25px 0; }
        .booking-info h3 { margin-top: 0; color: #000000; font-size: 18px; }
        .booking-info table { width: 100%; border-collapse: collapse; }
        .booking-info table td { padding: 8px 0; vertical-align: top; }
        .booking-info table td:first-child { font-weight: 600; width: 140px; color: #555; }
        .footer { background-color: #f9f9f9; padding: 20px 30px; text-align: center; font-size: 12px; color: #888888; }
        .qr-section { text-align: center; padding: 20px; background-color: #fafafa; margin: 20px 0; border-radius: 6px; }
        .btn { display: inline-block; padding: 12px 30px; background-color: #000000; color: #ffffff; text-decoration: none; border-radius: 6px; margin-top: 20px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>ARtifact Museum</h1>
        </div>
        
        <div class="success-badge">
            <div class="icon">✓</div>
            <h2>Ticket Confirmed!</h2>
        </div>
        
        <div class="content">
            <h2>Hello, {{ $ticket->user->name ?? 'Guest' }}!</h2>
            
            <p>Your ticket for {{ $exhibition->title }} has been confirmed.</p>
            
            <div class="booking-info">
                <h3>📌 Ticket Details</h3>
                <table>
                    <tr><td>Ticket Code:</td><td><strong>{{ $ticket->order_id }}</strong></td></tr>
                    <tr><td>Exhibition:</td><td><strong>{{ $exhibition->title }}</strong></td></tr>
                    <tr><td>Date:</td><td><strong>{{ \Carbon\Carbon::parse($exhibition->start_date)->format('l, F j, Y') }}</strong></td></tr>
                    <tr><td>Location:</td><td>{{ $exhibition->location }}</td></tr>
                    <tr><td>Payment Method:</td><td>{{ ucfirst($ticket->payment_method) }}</td></tr>
                </table>
            </div>

            <div class="qr-section">
                <p><strong>Your Ticket Code</strong></p>
                <div style="font-size: 32px; font-weight: bold; letter-spacing: 2px; color: #000;">
                    {{ $ticket->order_id }}
                </div>
                <p style="font-size: 12px; color: #888; margin-top: 10px;">Please show this code at the museum entrance</p>
            </div>
            
            <center>
                <a href="{{ route('user.tickets') }}" class="btn">View My Tickets</a>
            </center>
        </div>
        
        <div class="footer">
            <p>ARtifact Museum | Preserving Culture Through Innovation</p>
        </div>
    </div>
</body>
</html>
