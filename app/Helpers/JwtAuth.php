<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use App\User;
use DB;

class JwtAuth{

    public $key;

    public function __construct(){
      $this->key ='esta es mi clave secret.123456789***';
    }

    public function signup($email,$password,$getToken=null){

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
          $decode =JWT::decode($jwt,$this->key,['HS256']);

          if(is_null($getToken)){
            return $jwt;
          }else{
            return $decode;
          }
        }else{
          /*se retorna un error*/
            return [
              'status' =>'error',
              'message'=>'Login ha fallado'.$password
            ];
        }
    }

    public function checkToken($jwt,$getIdentity=false){
        $auth =false;

        try{
          $decoded  =JWT::decode($jwt,$this->key,['HS256']);
        }catch(\UnexpectedValueException $e){
          $auth =false;
        }catch(\DomainException $e){
          $auth =false;
        }

        if(is_object($decoded) && isse($decoded->sub)){
          $auth =true;
        }

        if($getIdentity){
          return $decoded;
        }

        return $auth;
    }
}
