<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;


class AuthenticationController extends Controller
{

     use APIResponse;

    /**
     * Login API
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->all();
                return $this->sendError(implode(', ', $errors));
            }
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = Auth::user();
                $data['token'] =  $user->createToken('MyApp')->plainTextToken;
                return $this->sendResponse($data,"Success");
            }
            else{
                return $this->sendError('Could not find an account matching these credentials.', Response::HTTP_UNAUTHORIZED);
            }
        }catch (\Exception $e){
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            $this->generalError();
        }

    }


    /**
     * Register API
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'c_password' => 'required|same:password'
            ]);

            if($validator->fails()){
                $errors = $validator->errors()->all();
                return $this->sendError(implode(', ', $errors));
            }
            DB::beginTransaction();
            $user=new User();
            $user->name = $request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->balance = 0;
            $user->qr_code = '';
            $user->save();
            DB::commit();
            $data['token'] =  $user->createToken('MyApp')->plainTextToken;
            return $this->sendResponse($data,"User was successfully created",Response::HTTP_CREATED);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            DB::rollBack();
            return $this->generalError();
        }
    }



}
