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
            'currentPage' => $request->currentPage ?? 1,
            'search' => $request->search ?? false,
            'filter' => $request->filter ?? false,
       ];
        return $this->postEngagementService->getAllPostEngagements($params);
    }

    public function store(StorePostEngagementRequest $request){
        return $this->postEngagementService->createPostEngagement($request);
    }

    public function update(UpdatePostEngagementRequest $request, int $id){
        return $this->postEngagementService->updatePostEngagement($request, $id);
    }

    public function destroy(int $id){
        return $this->postEngagementService->deletePostEngagement($id);
    }
}
