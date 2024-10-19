<?php
namespace App\Services\Notifications;

interface NotificationInterface
{
    public function send(array $data): void;
    public function sendLater(array $data): void;
}
