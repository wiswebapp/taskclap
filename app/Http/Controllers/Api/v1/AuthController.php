<?php

namespace App\Http\Controllers\API\v1;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseApiController;

class AuthController extends BaseApiController
{
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendFailedResponse('All Fields are required', self::HTTP_UNPROCESSABLE, $validator->errors() );
        }

        if( Auth::attempt(['email' => $request->email,'password' => $request->password])){
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken(config('app.name'))->plainTextToken;
            $success['name'] =  $authUser->name;

            return $this->sendSuccessResponse('User signed in success', $success);
        }
        else{
            return $this->sendFailedResponse('Invalid Username/Password.', self::HTTP_FORBIDDEN);
        }
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendFailedResponse('All Fields are required', self::HTTP_UNPROCESSABLE, $validator->errors() );
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendSuccessResponse('User signed up success', $success);
    }

    public function signout()
    {
        $user = auth('sanctum')->user();
        $user->tokens()->delete();

        return $this->sendSuccessResponse('User Logged out successfully.');

    }
}
