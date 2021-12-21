<?php

namespace App\Http\Controllers\Api;

use App\Events\PasswordResetEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function resetPassword(PasswordRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail($request->id);
            $user->password = bcrypt($request->password);
            $user->save();
            event(new PasswordResetEvent($user, $request->password));
            $data['message'] = 'Password reset successfully.';
            $data['data'] = $user;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    public function autoGeneratePassword()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = '';
        try {
            $number = substr(str_shuffle("0123456789"), 0, 1);
            $small = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 3);
            $capital = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);
            $special = substr(str_shuffle("!@$%:"), 0, 1);
            $code = $number . $small . $capital . $special;
            $data['data'] = str_shuffle($code);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }
}
