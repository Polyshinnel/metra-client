<?php

namespace App\Repository;

use App\Models\NotificationModel;
use App\Models\UserNotificationModel;

class UserNotificationRepository
{
    private UserNotificationModel $userNotificationModel;

    public function __construct(UserNotificationModel $userNotificationModel)
    {
        $this->userNotificationModel = $userNotificationModel;
    }

    public function getUserNotifications($userId): ?array {
        return $this->userNotificationModel::select(
            'user_notifications.status',
            'notifications.notification_title',
            'notifications.notification_text',
            'notifications.notification_type',
            'notifications.date_publish',
            'user_notifications.notification_id'
        )
            ->leftjoin('notifications', 'user_notifications.notification_id', '=', 'notifications.id')
            ->where('user_notifications.user_id', $userId)
            ->where('notifications.publish_status',1)
            ->orderBy('notifications.date_publish', 'DESC')
            ->get()
            ->toArray();
    }

    public function getUnreadNotifications(int $userId): ?array {
        return $this->userNotificationModel::where('status', 0)->get()->toArray();
    }

    public function updateNotification(array $filter, array $updateArr): void {
        $this->userNotificationModel::where($filter)->update($updateArr);
    }
}