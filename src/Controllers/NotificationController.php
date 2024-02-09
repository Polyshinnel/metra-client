<?php

namespace App\Controllers;

use App\Repository\NotificationRepository;
use App\Repository\UserNotificationRepository;

class NotificationController
{
    private UserNotificationRepository $userNotificationRepository;
    public function __construct(
        UserNotificationRepository $userNotificationRepository
    )
    {
        $this->userNotificationRepository = $userNotificationRepository;
    }

    public function getUserNotifications(int $userId): ?array {
        return $this->userNotificationRepository->getUserNotifications($userId);
    }

    public function getUnreadNotifications(int $userId): int {
        $unreadCount = 0;
        $result = $this->userNotificationRepository->getUnreadNotifications($userId);
        if(!empty($result)) {
            $unreadCount = count($result);
        }
        return $unreadCount;
    }

    public function updateNotificationStatus(int $userId, int $notificationId): void {
        $filter = [
            'user_id' => $userId,
            'notification_id' => $notificationId
        ];

        $updateArr = [
            'status' => 1
        ];
        $this->userNotificationRepository->updateNotification($filter, $updateArr);
    }
}