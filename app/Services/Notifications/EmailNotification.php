<?php

namespace App\Services\Notifications;

use App\Mail\VaccinationReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailNotification extends NotificationAbstract
{
    public function send(array $data): void
    {
        // Logic for sending email
        Mail::to($data['email'])->send(new VaccinationReminder($data['user']));
    }

    public function sendLater(array $data): void
    {
        Log::info('Preparing to send vaccination reminder to: ' . $data['user']->email);

        try {
            // Assuming the user's timezone is available in $data
            $userTimezone = $data['timezone']; // Example: 'Asia/Dhaka'

            // Convert the schedule date to the user's timezone and then to UTC
            $scheduledDate = Carbon::parse($data['scheduleDate'])
                ->subDay()
                ->setTimezone($userTimezone) // Set to user's timezone
                ->setTime(21, 0); // Set to 9 PM in user's timezone
            
            Log::info('scheduledDate: ' . $scheduledDate->toDateTimeString());
            // Convert to UTC for storing in the queue
            $scheduledDateUTC = $scheduledDate->setTimezone('UTC');

            // Send email the night before the vaccination date
            Mail::to($data['user']->email)->later(
                $scheduledDateUTC,
                // Carbon::parse($data['scheduleDate'])->setTimezone($userTimezone)->subDay()->setTime(21, 0),
                new VaccinationReminder($data['user'], $data['scheduleDate'])
            );
        } catch (\Exception $e) {
            Log::error('Error queuing mail: ' . $e->getMessage());
        }
    }
}
