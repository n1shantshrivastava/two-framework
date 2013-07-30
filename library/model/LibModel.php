<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 23/7/13
 * Time: 3:52 PM
 * To change this template use File | Settings | File Templates.
 */

class LibModel {
    /*
     * one model will be dedicated to one table.
     * table either developers can specify to constructor or by default model's name will be taken as table name
     */
    private $tableName;
    /*
     * a table will have the primary key.
     * primary key also can be specify by developer, otherwise it will be 'id'
     */
    private $primaryKey;
    public function __construct($table_name=null,$primary_key=null){
        if(!empty($table_Name)){
            $this->tableName=$table_name;
        }
        else{
            $modelName=get_class($this);
            $this->tableName=$modelName=strtolower(strstr($modelName,'Model',true));
        }
        if(!empty($primary_key)){
            $this->primaryKey=$primary_key;
        }
        else{
            $this->primaryKey='id';
        }
    }


    public function __set($key,$value){
        $this->{$key}=$value;
    }

    public function insertData($data=null){
        $db=LibDatabase::getDbInstance();
        if(!empty($data)){
            return($db->insert($this->tableName,$data));
        }

    }

    public function update($data,$condition=null){
        $db=LibDatabase::getDbInstance();
        if(empty($condition)&& !isset($this->{$this->primaryKey})){
            $parent=debug_backtrace();
            $count=count($parent);
            echo $count;
            echo '<pre>';
            //var_dump($parent);
            echo '</pre>';
            //throw new ApplicationException('Specify condition for updation',$parent[$count-4]['file'],$parent[$count-4]['line']);
        }
        return($db->update($this->tableName,$data,$condition));
    }

    public function delete($condition){
        $db=LibDatabase::getDbInstance();
        return($db->delete($this->tableName,$condition));
    }
    public function findAll(){
        $db=LibDatabase::getDbInstance();
        return($db->search($this->tableName,null,null));
    }
    public function findSpecific($column,$condition=null){
        $db=LibDatabase::getDbInstance();
        return($db->search($this->tableName,$condition,$column));
    }
    public function findByCondition($condition,$column=null){
        $db=LibDatabase::getDbInstance();
        return($db->search($this->tableName,$condition,$column));
    }
    public function save(){

    }
    public function query($string){
        $db=LibDatabase::getDbInstance();
        return($db->fireQuery($string));
    }
}