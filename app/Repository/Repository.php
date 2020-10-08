<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

abstract class Repository implements InterfaceRepository {

    protected $model;

    public function __construct(Model $modelClass) {
      $this->model  =$modelClass;
    }

    public function all($attributes=['*'],$orderBy=[['column'=>'id','direction'=>'desc']]){
      $model  =$this->model;
      if(!empty($orderBy)){
        foreach ($orderBy as $order) {
            $model=$model->orderBy($order['column'],$order['direction']);
        }
      }
       $model=$model->get($attributes);

       return $model;
    }

    public function find($id,$attributes=['*']){
        return $this->model->where('id',$id)->get()->first();
    }

    public function findByField($field,$value,$attributes=['*'],$orderBy=[]){

    }

    public function findWhere($where=[],$attributes=['*'],$orderBy=[]){

    }

    public function findWhereIn($where=[],$attributes=['*'],$orderBy=[]){

    }

    public function findWhereNotIn($field,$where=[],$attributes=['*'],$orderBy=[]){

    }

    public function create($attributes=[],$optional=[]){
        $return =(Object)[
            'response' => false,
        ];

        try{
            $return->response=true;
            $return->success=$this->model->create($attributes);
        }
        catch(\Exception $e){
            Log::info('create : '.$e->getMessage());
            $return->response=false;
            $return->error=$e->getMessage();
        }

        return $return;
    }

    public function update($id,$attributes=[],$optional=[]){
        $return =(Object)[
            'response' => false,
        ];

        try{
            $return->response=true;
            $return->success=$this->model->where('id',$id)->update($attributes);
        }
        catch(\Exception $e){
            Log::info('update : '.$e->getMessage());
            $return->response=false;
            $return->error=$e->getMessage();
        }

        return $return;
    }

    public function delete($id){
        $return =(Object)[
            'response' => false,
        ];

        try{
            $return->response=true;
            $return->success=$this->model->where('id',$id)->delete();
        }
        catch(\Exception $e){
            Log::info('delete : '.$e->getMessage());
            $return->response=false;
            $return->error=$e->getMessage();
        }

        return $return;

    }


}
