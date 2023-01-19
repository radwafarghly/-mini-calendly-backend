<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\Utility\ResponseType;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(UserFormRequest $request)
    {
        $credentials = $request->validated();
        if ($token = Auth::attempt($credentials)) {
            $authUser = auth()->user();
            return (new UserResource($authUser))
                ->additional(ResponseType::simpleResponse('User Login successfully', true, $this->respondWithToken($token)));
        }
        $resource = new UserResource(ResponseType::simpleResponse(trans('Unauthorized'), false));
        return $resource->response()->setStatusCode(401);
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 122222222
        ];
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
    /**
     * Get the  User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(User $user)
    {

        return (new UserResource($user))
            ->additional(ResponseType::simpleResponse('User data return successfully', true));
    }

    public function register(UserFormRequest $request)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        $user = User::create($data);
        \DB::commit();
        $token = Auth::login($user);
        return (new UserResource($user))
            ->additional(ResponseType::simpleResponse(trans('User created successfully'), true, $this->respondWithToken($token)));
    }

    public function logout()
    {
        Auth::logout();
        return (new UserResource([]))->additional(ResponseType::simpleResponse('Successfully logged out', true));
    }
}
