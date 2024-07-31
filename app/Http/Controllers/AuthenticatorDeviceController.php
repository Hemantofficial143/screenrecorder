<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Facade as Google2FA;
use App\Models\AuthenticatorDevice;
use Inertia\Inertia;


class AuthenticatorDeviceController extends Controller
{
    protected $modelObject;

    public function __construct(){
        $this->modelObject = new AuthenticatorDevice();
    }


    public function get2FACode(Request $request){
        $user = Auth::user();

        $google2fa = app('pragmarx.google2fa');
        $secretKey = $google2fa->generateSecretKey();

        session(['authenticator_secret_key' => $secretKey]);

        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secretKey
        );

        return ['success' => true,'qr_code' => $QR_Image,'key' => $secretKey];
    }

    public function set2FA(Request $request){
        $response = ['success' => false];
        $secretKey = session('authenticator_secret_key');
        $otp = $request->otp;
        $valid = Google2FA::verifyKey($secretKey, $otp);
        if($valid){
            $updated = $this->modelObject->saveRecord(['google2fa_secret' => $secretKey]);
            $response['success'] = $updated['success'];
        }
        return $response;
    }

    public function Verify2FACode(){
        return Inertia::render('Auth/Verify2Fa');
    }

    public function Verify2FACodeSubmit(Request $request){
        $authUser = Auth::user();
        $valid = false;
        $devicesEnrolledObject = new \App\Models\AuthenticatorDevice;
        $enrolledDevices = $devicesEnrolledObject->getDevicesByUser($authUser->user_id);
        foreach($enrolledDevices as $device){
            $verified = Google2FA::verifyKey($device->google2fa_secret, $request->one_time_password);
            if($verified){
                $request->session()->put('2fa_verified', true);
                $valid = true;
                break;
            }
        }
        if($valid){
            return redirect('dashboard');
        }
    }



}
