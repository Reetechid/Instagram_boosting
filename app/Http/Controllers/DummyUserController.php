<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DummyUser;
use App\Services\SuccessResponseService;

class DummyUserController extends Controller
{
    protected $successResponseService;

    public function __construct(SuccessResponseService $successResponseService)
    {
        $this->successResponseService = $successResponseService;
    }

    public function showAll()
    {
        $dummyUser = DummyUser::all();

        return $this->successResponseService->sendSuccessResponse($dummyUser);
    }

    public function show(Request $request, string $id)
    {
        $dummyUser = DummyUser::where("id", $id)->first();

        return $this->successResponseService->sendSuccessResponse($dummyUser);
    }

    public function create(Request $request)
    {
        $dummyUser = new DummyUser;

        $dummyUser->name = $request->input('name');
        $dummyUser->username = $request->input('username');
        $dummyUser->password = $request->input('password');
        $dummyUser->instagram_user = $request->input('instagram_user');
        $dummyUser->instagram_password = $request->input('instagram_password');
        $dummyUser->target_account_1 = $request->input('target_account_1');
        $dummyUser->target_account_2 = $request->input('target_account_2');
        $dummyUser->status = $request->input('status');
        $dummyUser->time_total_bot_used = 0;

        $dummyUser->save();

        return $this->successResponseService->sendSuccessResponse(null);
    }

    public function remove(Request $request, string $id)
    {
        $deleted = DummyUser::where('id', $id)->delete();

        if ($deleted == 1) {
            return $this->successResponseService->sendSuccessResponse($deleted);
        }
    }
}
