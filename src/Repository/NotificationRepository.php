<?php

namespace App\Repository;

use App\Models\NotificationModel;

class NotificationRepository
{
    private NotificationModel $notificationModel;

    public function __construct(NotificationModel $notificationModel)
    {
        $this->notificationModel = $notificationModel;
    }

    public function selectAllNotifications(): ?array {
        return $this->notificationModel::all->toArray;
    }

    public function createNotification($createArr): void {
        $this->notificationModel::create($createArr);
    }

    public function updateNotification($id, $updateArr): void {
        $this->notificationModel::where('id', $id)->update($updateArr);
    }

    public function deleteNotification($id): void {
        $this->notificationModel::where('id', $id)->delete();
    }
}