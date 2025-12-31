<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Mail\BookingReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendBookingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:send-reminders {--days=1 : Number of days before event to send reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for upcoming bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $targetDate = Carbon::now()->addDays($days)->startOfDay();
        $endDate = $targetDate->copy()->endOfDay();

        $this->info("Sending reminders for bookings on " . $targetDate->format('Y-m-d'));

        // Get bookings that:
        // 1. Have event_date between targetDate and endDate
        // 2. Haven't received reminder yet
        // 3. Are confirmed
        // 4. Have reminder enabled
        $bookings = Booking::whereNotNull('event_date')
            ->whereBetween('event_date', [$targetDate, $endDate])
            ->whereNull('reminder_sent_at')
            ->where('status', 'confirmed')
            ->where('reminder_enabled', true)
            ->with(['user', 'bookable'])
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('No bookings found for reminders.');
            return 0;
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($bookings as $booking) {
            try {
                if ($booking->user && $booking->user->email) {
                    Mail::to($booking->user->email)
                        ->send(new BookingReminderMail($booking));
                    
                    // Mark as sent
                    $booking->update(['reminder_sent_at' => now()]);
                    
                    $this->info("✓ Sent reminder to {$booking->user->email} for booking {$booking->booking_code}");
                    $sentCount++;
                } else {
                    $this->warn("✗ No email found for booking {$booking->booking_code}");
                    $failedCount++;
                }
            } catch (\Exception $e) {
                $this->error("✗ Failed to send reminder for booking {$booking->booking_code}: " . $e->getMessage());
                $failedCount++;
            }
        }

        $this->info("\n=== Summary ===");
        $this->info("Reminders sent: {$sentCount}");
        $this->info("Failed: {$failedCount}");
        $this->info("Total processed: " . ($sentCount + $failedCount));

        return 0;
    }
}
