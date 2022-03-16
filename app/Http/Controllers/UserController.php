<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\SuccessMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function registernew(Request $request){
        $res = $request->all();
        $validator_phone = Validator::make(
            $request->all(), [
                'phone' => 'required|numeric|min:11'
            ]);
        if ($validator_phone->fails()) {
            return dd("Invalid Phone Number!");
        }
        $validator_name = Validator::make(
            $request->all(), [
                'name' => 'required|min:5'
            ]);
        if ($validator_name->fails()) {
            return dd("Name must contain 5 characters!");
        }
        

        function checkemail($str) {
              return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
        }

        if(!checkemail($request->all()['email'])){
            return dd("Invalid Email Format!");
        }
        $user = User::create([
            'name'=> $request->all()['name'],
            'email'=> $request->all()['email'],
            'phone'=> $request->all()['phone'],
            'password'=> '12345678',
        ]);
        if($user){
            //mail
            $details = [
                'name'=> $request->all()['name'],
                'email'=> $request->all()['email'],
                'phone'=> $request->all()['phone']
            ];
            // Send email
            Mail::to($request->all()['email'])->send(new SuccessMail($details));
            return dd('Email has been sent to your registered mail, check your mail inbox');
        }
       
    }
          
} 
