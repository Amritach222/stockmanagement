<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogEvent;
use App\Http\Requests\ForgotPasswordSet;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserPasswordReset;
use App\Http\Requests\UserRegistration;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;


class AuthController extends Controller
{
    public function registerUser(UserRegistration $request)
    {
        if ($request->middle_name === null || $request->middle_name === '') {
            $name = trim($request->first_name . ' ' . $request->last_name);
        } elseif ($request->middle_name === null || $request->middle_name === '' || $request->last_name === null || $request->last_name === '') {
            $name = trim($request->first_name);
        } else {
            $name = trim($request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name);
        }
        try {
            $request->merge(['is_active' => 1]);
            $user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'name' => $name,
                'department_id' => $request->department_id,
                'is_active' => $request->is_active,
                'mobile_no' => $request->mobile_no,
                'address' => $request->address,
                'password' => bcrypt($request->password)
            ]);
        } catch (\Exception $exception) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $exception], 500);
        }
        $access_token = $user->createToken($user->username)->accessToken;
        $user->access_token = $access_token;
        $user->responseMessage = trans('messages.user_created');
        auth()->login($user);
        event(new ActivityLogEvent('Register', null, $user->id));
        return new AuthResource($user);
    }

    public function loginUser(UserLogin $request)
    {

        $login_credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        if (auth()->attempt($login_credentials)) {
            $user_login_token = auth()->user()->createToken($request->username)->accessToken;
            $user = auth()->user();
            $user->access_token = $user_login_token;
            $user->responseMessage = trans('messages.login_success');
            event(new ActivityLogEvent('Login', 'User'));
            return new AuthResource($user);
        } else {

            return response(['success' => false, "message" => trans('auth.failed'), "data" => []], 400);
        }
    }

    public function getUser()
    {
        try {
            return new AuthResource(auth()->user());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('auth.registerFailedUserInfo')]);
        }
    }

    public function logoutUser()
    {
        try {
            $user = auth()->user();
            auth()->user()->token()->revoke();
        } catch (\Exception $exception) {
            return response(['success' => false, "message" => trans('auth.logout_success'), "data" => []], 400);
        }
        event(new ActivityLogEvent('Logout', 'User', $user->id));
        return response(['success' => true, "message" => trans('auth.logout_success'), "data" => []], 200);
    }

    public function forgotUserPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usernameOrEmail' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response(['success' => false, 'message' => 'Invalid data parsed', "data" => $validator->errors()], 400);
        }

        if (filter_var($request->usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->usernameOrEmail)->first();
        } else {
            $user = User::where('username', $request->usernameOrEmail)->first();
        }
        if ($user === null) {
            return response(['success' => true, "message" => trans('messages.request_complete'), "data" => []], 200);
        }

        $data = ['user_id' => $user->id, 'user_email' => $user->email, 'requested_date' => Carbon::now()->toDateTimeString()];

        $text_data = json_encode($data);

        $encrypt_data = $this->encData($text_data);


        $email_data = ['code' => $encrypt_data, 'email' => $user->email, 'url' => env('APP_URL') . '/#/reset-password-confirm'];

        $send_mail = $this->sendResetEmail($email_data);

        if ($send_mail === true) {
            event(new ActivityLogEvent('Forgot Password', null, $user->id));
            return response(['success' => true, "message" => trans('messages.request_complete'), "data" => []], 200);
        } else {
            return response(['success' => false, "message" => trans('messages.request_complete'), "data" => []], 500);
        }

    }

    public function sendResetEmail($emailData)
    {
        try {
            Mail::send('mail.sam_reset_password', ['code' => $emailData['code'], 'url' => $emailData['url'], 'email' => $emailData['email']], function ($message) use ($emailData) {
                $message->to($emailData['email'], "User")->subject('Reset Account Password');
            });
        } catch (\Exception $e) {
            if ($e->getCode() === 554) {
                return false;
            }
        }
        return true;
    }

    public function setForgotNewPassword(ForgotPasswordSet $request)
    {
        $token = $request->token;
        $token = base64_decode($token);
        $user = User::where('id', $request->user_id)->where('remember_token', $token)->first();
        if ($user === null) {
            return response(['success' => false, "message" => trans('messages.error_data'), "data" => []], 422);
        }
        $user->remember_token = null;
        $user->password = bcrypt($request->password);
        $user->update();
        return response(['success' => true, "message" => trans('passwords.reset'), "data" => []], 200);
    }

    public function forgotUserPasswordCreate($code)
    {
        $decoded_data = $this->decData($code);
        $decoded_data = json_decode($decoded_data);
        if ($decoded_data === null) {
            return response(['success' => false, "message" => trans('messages.error_data'), "data" => []], 422);
        }
        $time_diff = Carbon::now()->diffInMinutes(Carbon::createFromDate($decoded_data->requested_date));
        if ($time_diff > 720) {
            return response(['success' => false, "message" => trans('passwords.token'), "data" => []], 422);
        }
        $user = User::where('id', $decoded_data->user_id)->first();
        $user->remember_token = rand();
        $user->update();
        return response(['success' => true, "message" => trans('messages.token_verified'), "data" => ['token' => base64_encode($user->remember_token), 'user_id' => $user->id]], 200);
    }

    public function resetUserPassword(UserPasswordReset $request)
    {
        if (filter_var($request->usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->usernameOrEmail)->first();
        } else {
            $user = User::where('username', $request->usernameOrEmail)->first();
        }
        $login_credentials = [
            'username' => $user->username,
            'password' => $request->previousPassword,
        ];
        if (auth()->attempt($login_credentials)) {
            $user->password = bcrypt($request->newPassword);
            $user->update();
            event(new ActivityLogEvent('Reset Password', null, $user->id));
            return response(['success' => true, "message" => trans('auth.password_changed'), "data" => []], 200);
        } else {
            return response(['success' => false, "message" => trans('auth.password'), "data" => ['previousPassword' => [trans('auth.password')]]], 422);
        }
    }

    public function encData(string $data)
    {
        $code = 'a23brhjty';
        $data = $code . $data . $code;
        $code1 = base64_encode($data);
        $code2 = str_shuffle('cmF3b3JrQ') . $code1 . str_shuffle('GdtYWlsLm');
        $code3 = base64_encode($code2);
        return $code3;
    }

    public function decData(string $data)
    {
        $code4 = base64_decode($data);
        $code5 = substr($code4, 9);
        $code6 = substr($code5, 0, -9);
        $code7 = base64_decode($code6);
        $code8 = substr($code7, 9);
        $code9 = substr($code8, 0, -9);
        return $code9;
    }

}
