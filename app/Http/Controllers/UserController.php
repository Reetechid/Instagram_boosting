<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\SuccessResponseService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $successResponseService;

    public function __construct(SuccessResponseService $successResponseService)
    {
        $this->successResponseService = $successResponseService;
    }

    public function showAll()
    {
        $user = User::all();

        return $this->successResponseService->sendSuccessResponse($user);
    }

    public function show(Request $request, string $id)
    {
        $user = User::where("id", $id)->first();

        return $this->successResponseService->sendSuccessResponse($user);
    }

    public function create(Request $request)
    {
        try {
            $user = User::create([
                "name" => $request->input("name"),
                "username" => $request->input("username"),
                "password" => bcrypt($request->input("password")),
                "instagram_user" => "",
                "account_expired" => $request->input("account_expired"),
                "ip_address" => $request->input("ip_address"),
                "account_role" => $request->input("account_role", "1"),
                "status" => "Stopped",
                "time_total_bot_used" => 0,
            ]);

            $user->save();
            return $this->successResponseService->sendSuccessResponse($user);
        } catch (\Exception $e) {
            if ($e instanceof \PDOException) {

                return response()->json([
                    'status' => 'failed',
                    'message' => $e->getMessage(),
                ], 500);
            }

        }
    }

    public function remove(Request $request, string $id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json([
            "status" => "success",
            "message" => "User successfully deleted."
        ]);
    }

    public function update(Request $request, string $id)
    {
        try {
            $user = User::find($id);

            $user->name = $request->input("name", $user->name);
            $user->account_expired = $request->input("account_expired", $user->account_expired);
            $user->ip_address = $request->input("ip_address", $user->ip_address);

            $user->save();

            return response()->json([
                "status" => "success",
                "message" => "User successfully updated."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failed",
                "message" => $e->getMessage(),
            ], 500);
        }

    }

    public function login(Request $request)
    {
        // $user = User::where('username', $request->input('username'))->firstOrFail();
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where("username", $request->username)->firstOrFail();
            $token = $user->createToken('auth_token', [$user->role])->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'account_role' => $user->account_role,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        // return response(200)
        //     ->json(['message'->$user]);
    }
}
