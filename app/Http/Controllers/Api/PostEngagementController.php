<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\StorePostEngagementRequest;
use App\Http\Requests\UpdatePostEngagementRequest;
use App\Services\PostEngagementService;
use App\Models\PostEngagement;

class PostEngagementController {
    protected $postEngagementService;

    public function __construct(PostEngagementService $postEngagementService) {
        $this->postEngagementService = $postEngagementService;
    }

    public function index(Request $request){
        $params = [
            'getAllData' => $request->getAllData ?? false,
            'perPage' => $request->perPage ?? 10,
            'page' => $request->page ?? 1,
            'search' => $request->search ?? false,
            'filter' => $request->filter ?? false,
       ];
        return $this->postEngagementService->getAllPostEngagements($params);
    }

    public function getUserPostEngagements(Request $request) {
        if($request->filled('post_id')) {
            return $this->postEngagementService->getUserPostEngagements($request->all());
        } else {
            return response()->json(['status' => 'failed', 'response' => 'The post_id field is required']);
        }
    }

    public function store(StorePostEngagementRequest $request){
        return $this->postEngagementService->createPostEngagement($request->validated());
    }

    // public function update(UpdatePostEngagementRequest $request, int $id){
    //     return $this->postEngagementService->updatePostEngagement($request->validated(), $id);
    // }

    public function destroy(Request $request){
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'user_id' => 'required',
            'post_id' => 'required',
            'type' => 'required',
        ], [
            'user_id.required' => 'The user_id field is required.',
            'post_id.required' => 'The post_id field is required.',
            'type.required' => 'The type field is required.',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'response' => $validator->errors(),
            ], 200);
        }

        return $this->postEngagementService->deletePostEngagement($validator->validated());
    }
}
