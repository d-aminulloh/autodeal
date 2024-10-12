<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use ResponseService;

class ApiAuthController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            $messages = $validator->messages();
            if($messages->get('email')) {
                if($messages->get('email')[0] == 'The email has already been taken.') {
                    return ResponseService::notSuccess($messages, 'Email sudah terdaftar.');
                }
            }
            return ResponseService::notSuccess($messages, 'Pendaftaran gagal. Username, Email dan Password harus diisi.');
        }
        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return ResponseService::success($success, "Pendaftaran berhasil.");
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) return ResponseService::notSuccess($validator->messages(), 'Username dan password harus diisi.');
        $input = $request->all();

        $credentials = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        if ($input['remember']) {
            $remember = true;
        } else {
            $remember = false;
        }

        if (Auth::attempt($credentials, $remember)) {
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['email'] = $auth->email;
            // $success['driver'] = Auth::getDefaultDriver();

            return ResponseService::success($success, "Login berhasil.");
        } else {
            return ResponseService::notSuccess([], "Login gagal. Harap periksa kembali username dan password anda.");
        }
        // $credentials = request(['email' => $request->email, 'password' => $request->password]);
        // $token = auth()->guard('web')->attempt($credentials);
        // if (!$token) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        // return response()->json([
        //     'access_token' => $token,
        //     'token_type'   => 'bearer',
        //     'expires_in'   => auth('api')->factory()->getTTL() * 60,
        // ]);
    }

    // public function forgotPassword(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //     ]);
    //     if ($validator->fails()) return ResponseService::notSuccess($validator->messages(), 'Email harus diisi.');
    //     $email = $request->email;
    //     $user = User::where('email', $email)->first();

    //     if (!$user) {
    //         return ResponseService::notSuccess([], 'Email tidak terdaftar.');
    //     }

    //     $otp = rand(100000, 999999);
    //     $user->otp = $otp;
    //     $user->save();

    //     $details = [
    //         'title' => 'Kode OTP Autodeal',
    //         'body' => 'Kode OTP Anda adalah '.$otp
    //     ];

    //     Mail::to($email)->send(new ForgotPasswordMail($details));

    //     return ResponseService::success([], "Kode OTP berhasil dikirim. Silakan periksa email Anda.");
    // }

    public function forgotPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::broker('users')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? ResponseService::success([], __($status))
            : ResponseService::notSuccess([], __($status));
    }


}
