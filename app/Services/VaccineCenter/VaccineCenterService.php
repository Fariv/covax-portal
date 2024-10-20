<?php

namespace App\Services\VaccineCenter;

use App\Models\User;
use App\Models\VaccineCenter;
use App\Services\Notifications\EmailNotification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class VaccineCenterService extends VaccineCenterServiceAbstract
{

    protected $mailNotification;

    public function __construct(EmailNotification $mailNotification)
    {
        $this->mailNotification = $mailNotification;
    }
    
    /**
     * Registers a user to a vaccine center and schedules their vaccination date.
     *
     * @param User $user
     * @param int $centerId
     * @param string $timezone
     * @return void
     */
    public function registerUserToCenter(User $user, int $centerId, string $timezone): void
    {
        try {
            Log::info('Registering user to center: User ID - ' . $user->id . ', Center ID - ' . $centerId);
            // Get the vaccine center and its max limit
            $vaccineCenter = VaccineCenter::findOrFail($centerId);
            Log::info('Vaccine center found: ' . $vaccineCenter->id);

            // Calculate the next available date, skipping weekends (Friday, Saturday)
            $nextAvailableDate = $this->getNextAvailableVaccinationDate($vaccineCenter, $timezone);
            Log::info('Next available vaccination date: ' . $nextAvailableDate);

            $insertData = [
                'users_id' => $user->id,
                'centers_id' => $centerId,
                'schedule_vaccination_date' => $nextAvailableDate,
                'status' => 'Scheduled',
            ];
            
            // Register user to vaccine center
            $isInserted = DB::table('users_vaccine_centers')->insert($insertData);
            Log::info('User registered to center: ' . ($isInserted ? 'Success' : 'Failed'));

            $scheduleDate = DB::table('users_vaccine_centers')
                ->where('users_id', $user->id)
                ->value('schedule_vaccination_date');
            Log::info('Schedule date retrieved: ' . $scheduleDate);

            $parameter = array(
                "user" => $user,
                "scheduleDate" => $scheduleDate,
                "timezone" => $timezone,
            );

            Log::info('Parameters for sendLater: ' . json_encode($parameter));
            // Schedule the email notification for the user
            $this->mailNotification->sendLater($parameter);
        } catch (\Exception $e) {
            Log::error('Error in registerUserToCenter: ' . $e->getMessage());
        }
    }

    /**
     * Calculates the next available vaccination date, skipping Fridays and Saturdays.
     *
     * @param VaccineCenter $vaccineCenter
     * @return Carbon
     */
    private function getNextAvailableVaccinationDate(VaccineCenter $vaccineCenter, string $userTimezone): Carbon
    {
        $currentDate = Carbon::now($userTimezone);
        $currentHour = $currentDate->hour;

        // Check if current time is after 9 AM
        if ($currentHour >= 9) {
            $currentDate->addDay(); // Move to the next day since the user can't be assigned on the same day after 10 AM
        }

        Log::info('checkDateAvail: ' . ($currentDate->isFriday() || $currentDate->isSaturday()));
        // Find the next available date that is not a weekend
        while ($currentDate->isFriday() || $currentDate->isSaturday() || $this->isDateFullyBooked($currentDate, $vaccineCenter)) {
            $currentDate->addDay();
            Log::info('currentDate after day added: ' . $currentDate->startOfDay());
        }

        return $currentDate;
    }

    public function getAllCenters()
    {
        $centers = VaccineCenter::select('id', 'name')->orderBy('sort', 'asc')->get();

        return $centers;
    }

    /**
     * Check if the vaccination date is fully booked.
     *
     * @param Carbon $date
     * @param VaccineCenter $vaccineCenter
     * @return bool
     */
    private function isDateFullyBooked(Carbon $date, VaccineCenter $vaccineCenter): bool
    {
        $vaccinatedCount = DB::table('users_vaccine_centers')
            ->where('centers_id', $vaccineCenter->id)
            ->whereBetween('schedule_vaccination_date', [$date->startOfDay(), $date->endOfDay()]) // Full day range
            ->count();

        Log::info('vaccinatedCount: ' . $vaccinatedCount . ' for date: ' . $date->startOfDay());

        return $vaccinatedCount >= $vaccineCenter->maximum_limit;
    }
}
