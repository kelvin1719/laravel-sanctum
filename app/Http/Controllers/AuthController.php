<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function  register(Request $request){

        $rules = array(
            'name'=> 'required',
            'email'=>'required|unique:users',
            'password'=> 'required|confirmed',
        );


        $validate = Validator::make($request->all() , $rules);

        if($validate->fails()){
            return (new ResponseController())->Error("Validation Erorr" , $validate->errors());
        }

        $insert = new User() ;
        $insert['name'] = $request->name;
        $insert['email'] = $request->email;
        $insert['password'] = Hash::make($request->password);
        $dbSave = $insert->save() ;
        $token = $insert->createToken('myapptoken')->plainTextToken ;
        if($dbSave){
           return response()->json([
               'user'=>$insert,
               'token'=>$token
           ]);
//            return (new ResponseController())->Success('Registration Successfull' , $insert);

        }
    }
    public function logout(){
        auth()->user()->token()->delete();
        return 'logged out';
    }


}
