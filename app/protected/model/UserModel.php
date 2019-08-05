<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 24/7/13
 * Time: 4:41 PM
 * To change this template use File | Settings | File Templates.
 */
class UserModel extends LibModel{

    public function getAll(){
        return($this->findAll());
    }
    public function insert($data){
        $this->insertData($data);
    }
    public function getByCondition($condition){
        return($this->findByCondition($condition,array('id','fname')));
    }
}