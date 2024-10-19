<?php

namespace App\Services\VaccineCenter;

use App\Models\User;
use App\Services\Notifications\NotificationAbstract;

abstract class VaccineCenterServiceAbstract extends NotificationAbstract
{
    /**
     * Registers a user to a vaccine center.
     *
     * @param User $user
     * @param int $centerId
     * @param string $timezone
     * @return void
     */
    public function registerUserToCenter(User $user, int $centerId, string $timezone): void {

    }
}
