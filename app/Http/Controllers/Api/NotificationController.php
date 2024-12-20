<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Services\NotificationService;
use App\Models\Notification;

class NotificationController {
    protected $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request){
        $params = [
            'getAllData' => $request->getAllData ?? true,
            'perPage' => $request->perPage ?? 10,
            'page' => $request->page ?? 1,
            'search' => $request->search ?? false,
            'filter' => $request->filter ?? false,
        ];
        return $this->notificationService->getAllNotifications($params);
    }

    public function store(StoreNotificationRequest $request){
        return $this->notificationService->createNotification($request->validated());
    }

    // public function update(UpdateNotificationRequest $request, int $id){
    //     return $this->notificationService->updateNotification($request->validated(), $id);
    // }

    public function notificationReaded(int $id){
	return $this->notificationService->readNotification($id);	
    }

    public function destroy(int $id){
        return $this->notificationService->deleteNotification($id);
    }
}

