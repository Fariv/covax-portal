<?php

namespace App\Services\Notifications;


abstract class NotificationAbstract implements NotificationInterface
{
    public function send(array $data): void {

    }

    public function sendLater(array $data): void {

    }
}
