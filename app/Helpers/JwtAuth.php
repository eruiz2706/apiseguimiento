<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use App\User;
use DB;
use Validator;

class JwtAuth{

    public $key;

    public function __construct(){
      $this->key ='secret.123456789***';
    }

    public function signup($email,$password){

        $user = User::where(array(
          'email' =>$email,
          'password' =>$password
        ))->first();

        if(is_object($user)){
          /*se genera el token y se devuelve*/
          $token  =[
            'sub' =>$user->id,
            'email' =>$user->email,
            'name' =>$user->name,
            'iat' =>time(),
            'exp' =>time()+(7*24*60*60)
          ];

          $jwt  =JWT::encode($token,$this->key,'HS256');

          return [
            'status'=>'success',
            'user' =>$user,
            'identity'=>$jwt
          ];
        }else{
          /*se retorna un error*/
            return [
              'status' =>'error',
              'errors' =>[],
              'message'=>'Usuario o contraseña invalida'
            ];
        }
    }

    public function checkToken($jwt){
        $auth   =false;
        $decoded=[];

        try{
          $decoded  =JWT::decode($jwt,$this->key,['HS256']);
        }catch(\UnexpectedValueException $e){
          $auth =false;
        }catch(\DomainException $e){
          $auth =false;
        }

        if(is_object($decoded) && isset($decoded->sub)){
          $auth =true;
        }

        return $auth;
    }

    public function decodeToken($jwt){
        $auth   =false;
        $decoded=[];

        try{
          $decoded  =JWT::decode($jwt,$this->key,['HS256']);
        }catch(\UnexpectedValueException $e){

        }catch(\DomainException $e){

        }


        return $decoded;
    }
}
