<?php

namespace App\Repository;

use App\Models\UserNotificationModel;

class UserNotificationRepository
{
    private UserNotificationModel $userNotificationModel;

    public function __construct(UserNotificationModel $userNotificationModel)
    {
        $this->userNotificationModel = $userNotificationModel;
    }

    public function selectNotification($userId): ?array {
        return $this->userNotificationModel::where('user_id', $userId)->orderBy('date_create', 'DESC')->get()->toArray();
    }

    public function updateNotification($userId, $updateArr): void {
        $this->userNotificationModel::where('user_id', $userId)->update($updateArr);
    }
}