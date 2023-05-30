<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Response\Message;
use App\Models\User;
use App\Functions\GlobalFunction;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;

class UserController extends Controller
{
    public function index(Request $request){
        $user = User::get()->first();

         return GlobalFunction::response_function(Message::USER_DISPLAY,$user);
    }

    public function store(Request $request){
      
        $user =  User::create([
            "account_code" => $request["code"],
            "account_name" => $request["name"],

            "location_id" => $request["location"]["id"],
            "location_code" => $request["location"]["code"],
            "location" => $request["location"]["name"],

            "department_id" => $request["department"]["id"],
            "department_code" => $request["department"]["code"],
            "department" => $request["department"]["name"],

            "company_id" => $request["company"]["id"],
            "company_code" => $request["company"]["code"],
            "company" => $request["company"]["name"],

            "role_id" => $request["role_id"],
            "mobile_no" => $request["mobile_no"],
            "username" => $request["username"],
            "password" => Hash::make($request["username"]),
        ]);
       return GlobalFunction::save(Message::REGISTERED,$user);
    }
      public function login(LoginRequest $request)
    {
        $user = User::where("username", $request->username)->first();
            

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "username" => ["The provided credentials are incorrect."],
                "password" => ["The provided credentials are incorrect."],
            ]);

            if ($user || Hash::check($request->password, $user->username)) {
                return GlobalFunction::login_user(Message::INVALID_ACTION);
            }
        }
        $token = $user->createToken("PersonalAccessToken")->plainTextToken;
        $user["token"] = $token;
        $user = new LoginResource($user);

        $cookie = cookie("authcookie", $token);

        return GlobalFunction::response_function(Message::LOGIN_USER, $user)->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        // auth()->user()->tokens()->delete();//all token of one user
        auth()
            ->user()
            ->currentAccessToken()
            ->delete(); //current user
        return GlobalFunction::response_function(Message::LOGOUT_USER);
    }
}
