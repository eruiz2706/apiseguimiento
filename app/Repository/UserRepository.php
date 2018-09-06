<?php
namespace App\Repository;

use App\Models\User;
use DB;
use Log;

class UserRepository extends Repository{

  public function __construct(User $model){
     parent::__construct($model);
  }

  public function alldata(){
    $data  =DB::select("select u.id,u.name,u.email,ru.role_id as idrol,r.name as nomrol
                        from users u
                        left join role_user ru on(u.id=ru.user_id)
                        left join roles r on(ru.role_id=r.id)
                        order by u.id desc");

     return $data;
  }

  public function createuser($attributes=[],$params=[]){
      $return =(Object)[
          'response' => false,
      ];

      DB::beginTransaction();
      try{
          $user =$this->model->create($attributes);
          if(isset($params['rol'])){
            DB::table('role_user')->insert([
              'user_id' =>$user->id,
              'role_id' =>$params['rol']
            ]);
          }

          $return->response=true;
          $return->success=$user;
          DB::commit();
      }
      catch(\Exception $e){
          Log::info('create : '.$e->getMessage());
          $return->response=false;
          $return->error=$e->getMessage();
          DB::rollback();
      }

      return $return;
  }

  public function updateuser($id,$attributes=[],$params=[]){
      $return =(Object)[
          'response' => false,
      ];

      DB::beginTransaction();
      try{

          $user =$this->model->where('id',$id)->update($attributes);

          if(isset($params['rol'])){
            DB::table('role_user')->where('user_id',$id)->update([
              'role_id' =>$params['rol']
            ]);
          }

          $return->response=true;
          $return->success=$user;
          DB::commit();
      }
      catch(\Exception $e){
          Log::info('update : '.$e->getMessage());
          $return->response=false;
          $return->error=$e->getMessage();
          DB::rollback();
      }

      return $return;
  }

  public function find($id,$attributes=['*'],$orderBy=[]){
      $user   =$this->model->where('id',$id)->get()->first();

      $rol  =DB::select("select role_id
                          from role_user
                          where user_id = :idusu"
                         ,['idusu'=>$id]);
      $user['rol']=$rol[0]->role_id;

      return $user;
  }

}
