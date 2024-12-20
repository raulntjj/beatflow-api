<?php

namespace App\Services;

use App\Models\Follow;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class FollowService {
    public function createFollow(array $request) {
        try {
            $userAuth = Auth::guard('api')->user();
            $follow = DB::transaction(function() use ($request) { 
                return Follow::create([
                    'followed_id' => $request['followed_id'],
                    'follower_id' => $request['follower_id'],
                ]);
            });


            // Instanciando serviço
            $notificationService = app(NotificationService::class);
            $notificationService->createNotification([
                'user_id' => $request['followed_id'],
                'type' => 'follow',
                'is_read' => false,
                'notifier_name' => $userAuth->user
            ]);

            return response()->json(['status' => 'success', 'response' => $follow]);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'response' => $e->getMessage()]);
        }
    }

    public function deleteFollow(Array $request) {
        try {
            $follow = DB::transaction(function() use ($request) {
                $follow =  Follow::where('follower_id', $request['follower_id'])
                ->where('followed_id', $request['followed_id'])
                ->get();

                if (!$follow) {
                    throw new Exception("Follow not found");
                }

                foreach($follow as $follow_unity) {
                    $follow_unity->delete();
                }
                return $follow;
            });

            return response()->json(['status' => 'success', 'response' => 'Follow deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'response' => $e->getMessage()]);
        }
    }
}
