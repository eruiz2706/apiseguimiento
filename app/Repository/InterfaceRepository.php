<?php

namespace App\Repository;

Interface InterfaceRepository{

    public function all($attributes=['*'],$orderBy=[['column'=>'id','direction'=>'desc']]);

    public function find($id,$attributes=['*']);

    public function findByField($field,$value,$attributes=['*'],$orderBy=[]);

    public function findWhere($where=[],$attributes=['*'],$orderBy=[]);

    public function findWhereIn($where=[],$attributes=['*'],$orderBy=[]);

    public function findWhereNotIn($field,$where=[],$attributes=['*'],$orderBy=[]);

    public function create($attributes=[],$params=[]);

    public function update($id,$attributes=[],$params=[]);

    public function delete($id);

}
