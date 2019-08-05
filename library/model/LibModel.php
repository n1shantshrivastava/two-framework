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
        if(!empty($table_name)){
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
        //-------------------------------------------------------------------


    }

    public function __set($key,$value){
        $this->{$key}=$value;
    }

    public function insertData($data=null){
        $db=LibDatabase::getDbInstance();
        if(!empty($data)){
            return($db->generateQuery('Insert',$this->tableName,$data,null));
        }

    }

    public function updateData($data,$condition=null){
        $db=LibDatabase::getDbInstance();
        return($db->generateQuery('Update',$this->tableName,$data,$condition));
    }

    public function deleteData($condition=null){
        $db=LibDatabase::getDbInstance();
        if(empty($condition)){
            $condition=array($this->primaryKey,'=',$this->{$this->primaryKey});
        }
        $cnt=$db->generateQuery('Delete',$this->tableName,null,$condition);
        if($cnt>0){
            if(isset($this->{$this->primaryKey})){
                $fields=$this->getFields();
                $data=array();
                foreach($this as $key=>$value){
                    if(in_array($key,$fields)){
                        unset($this->{$key});
                    }
                }
            }
        }
        return($cnt);
    }

    public function findAll(){
        $db=LibDatabase::getDbInstance();
        return($db->generateQuery('Find',$this->tableName,null,null));
    }

    public function findSpecific($column,$condition=null){
        $db=LibDatabase::getDbInstance();
        return($db->generateQuery('Find',$this->tableName,$column,$condition));
    }

    public function findByCondition($condition,$column=null){
        $db=LibDatabase::getDbInstance();
        return($db->generateQuery('Find',$this->tableName,$column,$condition));
    }

    //------------------------------------------------------------------------
    public function save(){
        $db=LibDatabase::getDbInstance();
        $fields=$this->getFields();
        $data=array();
        foreach($this as $key=>$value){
            if(in_array($key,$fields)){
                $data[$key]=$value;
            }
        }
        if(!empty($data)){
            if(($db->generateQuery('InsertOrUpdate',$this->tableName,$data,null))>0){
                $arr=$db->fireQuery("select LAST_INSERT_ID() as id");
                $this->{$this->primaryKey}=$arr[0]['id'];

            }
        }

        //return());
    }
    //----------------------------------------------------------------------------
    public function query($string){
        $db=LibDatabase::getDbInstance();
        return($db->fireQuery($string));
    }
    private function getFields(){
        $db=LibDatabase::getDbInstance();
        $rows=$db->fireQuery('SHOW COLUMNS FROM user');
        $fields=array();
        foreach($rows as $row){
            $fields[]=$row['Field'];
        }
        return $fields;
    }
}