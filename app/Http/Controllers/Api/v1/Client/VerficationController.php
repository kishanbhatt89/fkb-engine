<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Client\ForgotPasswordRequest;
use App\Http\Requests\Api\v1\Client\OtpVerifyRequest;
use App\Http\Requests\Api\v1\Client\ResetPasswordRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerficationController extends Controller
{

    /*
    public function emailVerify($client_id, Request $request) 
    {
        if (!$request->hasValidSignature()) 
        {
            return response()->json(["msg" => "Invalid/Expired url provided."], 200);
        }
    
        $client = Client::findOrFail($client_id);
    
        if (!$client->hasVerifiedEmail()) 
        {
            $client->markEmailAsVerified();
        }
    
        return response()->json(['msg' => 'Email verified successfully.'], 200);
    }
    */
    
    /*
    public function emailResend() 
    {
        
        if (auth('client')->user()->hasVerifiedEmail()) 
        {
            return response()->json(["msg" => "Email already verified."], 200);
        }
    
        auth('client')->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"], 200);
    }
    */

    /*
    public function smsVerify($client_id, Request $request)
    {
        $client = Client::where('id', $client_id)->update(['sms_verified_at' => now()]);

        if ($client) 
        {
            return response()->json(['msg' => 'Phone verified successfully.'], 200);    
        }

        return response()->json(['msg' => 'Something went wrong!'], 400);
    }
    */

    public function otpVerfiy(OtpVerifyRequest $request)
    {
        $otp = $request->otp;        

        if (!$request->bearerToken()) {

            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);

        }

        $client = JWTAuth::parseToken()->authenticate();        

        if (!$client) {

            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);

        }        

        if ($otp == '000000') {            

            $client->sms_verified_at = now();

            $client->save();

            return response()->json([                                
                'msg'   => 'OTP verified successfully.',
                'status'   => true,
                'data'  => [
                    //'token' => JWTAuth::getToken(),
                    'client' => $client, 
                    'clientDetails' => $client->clientDetails,
                    'store' => $client->store,
                ]
            ], 200);

        } 

        return response()->json([                         
            'msg'   => 'Invalid otp',
            'status'   => false,
            'data'  => (object) []
        ], 200);
    }

    public function resetPasswordOtpVerfiy(OtpVerifyRequest $request) {

        $otp = $request->otp;

        $client = JWTAuth::parseToken()->authenticate();       

        if (!$request->bearerToken()) {

            return response()->json([                
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);

        } 

        if (!$client) {

            return response()->json([                              
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);

        }        

        if ($otp == '000000') {                        

            return response()->json([                               
                'msg'   => 'OTP verified successfully.',
                'status'   => true,
                'data'  => [
                    'token' => JWTAuth::getToken()                    
                ]
            ], 200);

        } 

        return response()->json([            
            'msg'   => 'Invalid otp',
            'status'   => false,
            'data'  => (object) []
        ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request) {

        $password = $request->password;        

        $client = JWTAuth::parseToken()->authenticate();        

        if (!$client) {

            return response()->json([                               
                'msg'   => 'Invalid token or token not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);
        }        

        $client->password = bcrypt($password);
        $client->last_password_change_at = now();
        $client->save();

        return response()->json([                       
            'msg'   => 'Password changed successfully.',
            'status'   => true,
            'data'  => (object) []
        ], 200);

    }

    public function forgotPassword(ForgotPasswordRequest $request) {
        
        $client = Client::where('phone', $request->phone)->first(); 
        
        if (!$client) {
            
            return response()->json([
                'msg'   => 'Phone number not found.',
                'status'   => false,
                'data'  => (object) []
            ], 200);        

        }
        
        Auth::login($client);

        $token = auth('client')->refresh();

        return response()->json([            
            'msg' => '',
            'status' => true,
            'data' => [
                'otp' => '000000',
                'token' => $token
            ]
        ], 200);

    }

}
