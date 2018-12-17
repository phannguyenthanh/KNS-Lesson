<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\School;
use Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // try{

            $arr = $request->all();
            $validator = Validator::make($arr, [
                'email' => 'required|string|email|max:190|unique:users',
                'name'  =>  'string|min:8|max:190',
                'password' => 'required|min:6|string'
            ],[
                'email.required'    => 'email không được để trống',
                'email.string'   => 'email sai định dạng',
                'email.email'   => 'email sai định dạng',
                'email.unique'   => 'email đã tồn tại',
                'name.string'   => 'Tên sai định dạng',
                'name.min'   => 'Tên phải có ít nhất 6 ký tự',
                'name.max'   => 'Tên chỉ được phép nhiều nhất 190 ký tự',
                'password.min'   => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.required'   => 'Mật khẩu không được để trống'
            ]);

            if(!$validator->fails()){
                $arr['password'] = Hash::make($arr['password']);
                $user = User::create($arr);
                return response()->json([
                    'data' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'school_id' => $user->school_id,
                        'tel' => $user->tel,
                        'area_id' => $user->area_id,
                        'province_id' => $user->province_id,
                        'class_id' => $user->class_id,
                        'grade_id' => $user->grade_id,
                        'district_id' => $user->district_id,
                        'quantity_student' => $user->quantity_student,
                        'role_id' => $user->role_id,
                        'IP'    => request()->ip()
                    ],
                    'code'  => '0'
                ],200);
            }else{
                $error = $validator->errors();
                return response()->json(['error' => $error, 'code' => 104], 200);
            }
            
        // }
        // catch (\Exception $e) {
        //     $array = ['error' => $e->getMessage()];
        //     return response()->json([$array], 104);
        // }
        
    }


	//Login
    public function login(Request $request)
    {

//        try {
            $email = $request->email;
            $password = Hash::make($request->password);
            $validator = Validator::make([
                'email' => 'required|string|email',
                'password' => 'required|min:6|string'
            ],[
                'email.required'    => 'email không được để trống',
                'email.string'   => 'email sai định dạng',
                'email.email'   => 'email sai định dạng',
                'email.unique'   => 'email đã tồn tại',
                'password.min'   => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.required'   => 'Mật khẩu không được để trống'
            ]);
            if(!$validator->fails()){
                $credentials = $request->only('email', 'password');
                $user = User::where('email',$email)->first();
                if(!is_null($user->token)){
                    return response()->json(['message'=>'Tài khoản đã đăng nhập trên hệ thống', 'code' => 1],200);
                }else{
                    if(!is_null($user->school_id)){
                        $license_key = School::where('id',$user->school_id)->first()->license_key;
                    }else{
                        $license_key = '';
                    }
                    if(!is_null($user) && Hash::check('password',$password)){
                        if (Auth::attempt($credentials)) {
                            $user->token = Str::random(30);
                            $user->save();
                            return response()->json([
                                'data' => [
                                    'name' => $user->name,
                                    'email' => $user->email,
                                    'school_id' => $user->school_id,
                                    'token' =>  $user->token,
                                    'tel' => $user->tel,
                                    'area_id' => $user->area_id,
                                    'province_id' => $user->province_id,
                                    'class_id' => $user->class_id,
                                    'grade_id' => $user->grade_id,
                                    'district_id' => $user->district_id,
                                    'quantity_student' => $user->quantity_student,
                                    'role_id' => $user->role_id,
                                    'license_key'   => $license_key,
                                    'IP'    => request()->ip()
                                ],
                                'code'=>0
                            ],200);
                        }else{
                            return response()->json([
                                ['message' => 'Unauthorized', 'code' => 1]
                            ], 202);
                        }

                    }else{
                        return response()-json(['message'=>'Email hoặc mật khẩu không đúng', 'code' => 1],200);
                    }
                }
                

            }





//        } catch (\Exception $e) {
//            $array = ['message' => errorSystem, 'error' => $e->getMessage()];
//            return response()->json([
//                $array
//            ], 502);
//        }

    }
}