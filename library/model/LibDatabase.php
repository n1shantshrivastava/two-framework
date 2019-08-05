<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 25/7/13
 * Time: 10:52 AM
 * To change this template use File | Settings | File Templates.
 */

class LibDatabase{
private $connection;
private static $instance=null;
    private function __construct(){
        $dsn=Application::db()->DB_DRIVER.':dbname='.Application::db()->DATABASE.';host='.Application::db()->HOST.';charset='.Application::db()->CHARSET;
        try{
            $this->connection=new PDO($dsn,Application::db()->USER,Application::db()->PASSWORD, array(
                PDO::ATTR_PERSISTENT => true
            ));
        }
        catch(Exception $e){
            throw new ApplicationException("Error in establishing the Database connection",__FILE__,__LINE__);
        }
    }
    public static function getDbInstance(){
        if(empty(self::$instance)){
            self::$instance=new LibDatabase();
        }
        return (self::$instance);
    }
    /*
     * any condition will be in form of operand,operator,operand,
     * so condition must be array of 3. if you want more than on condition you can replace  operand with array of condition like,
     * array( array('a','>','20'),'and',array('b','in',array(1,2,3,4))) will be equivalent to 'where a > 20 and b in (1,2,3,4)'
     *
     * supported operators  are
     * = >,>=,<,<=,and,or,in,not in,like,not like
     */
    private function generateCondition($conditions){
        $expr='';
        $supported=array('=','>','>=','<','<=','and','or','in','not in','like','not like');
        if(in_array(strtolower($conditions[1]),$supported)){
            if(is_array($conditions[0])&& is_array($conditions[2])&&($conditions[1] == 'and'||$conditions[1] == 'or')){
                $expr.=$this->generateCondition($conditions[0]).' ';
                $expr.=strtolower($conditions[1]).' ';
                $expr.=$this->generateCondition($conditions[2]).' ';
            }
            elseif(is_array($conditions[2])&&( strtolower($conditions[1])=='in' || strtolower($conditions[1])=='not in')){
                $expr.=$conditions[0].' ';
                $expr.=strtolower($conditions[1]).' (';
                foreach($conditions[2] as $value){
                    $expr.=$value.',';
                }
                $expr=substr($expr,0,strlen($expr)-1);
                $expr.=')';
            }
            else{
                $expr.=$conditions[0].' ';
                $expr.=strtolower($conditions[1]).' ';
                $expr.='\''.$conditions[2].'\' ';
            }

            return $expr;
        }
        else{
            $parent=debug_backtrace();
            $total_call=count($parent);
            throw new ApplicationException("operator you are using is not supported in this function ",$parent[$total_call-4]['file'],$parent[$total_call-4]['line']);
        }
    }


    public function generateQuery($operation,$table,$data,$conditions){
        $method='generate'.$operation;
        if(method_exists($this,$method)){
            $query=$this->$method($table,$data,$conditions);
            $return_value=$this->fireQuery($query);
            return $return_value;
        }
    }
    private function generateUpdate($table,$data,$conditions){
        $query='update '.$table.' set';
        $input=array();
        foreach($data as $key=>$value){
            $query.=' '.$key.'=';
            $query.='\''.$value.'\',';
        }
        $query=substr($query,0,strlen($query)-1);
        if(!empty($conditions)){
            $where=$this->generateCondition($conditions);
            $query.=' where '.$where;
        }
        return $query;
    }

    private function generateDelete($table,$data,$conditions){
        if(!empty($conditions)){
            $where=$this->generateCondition($conditions);
            $query='delete from '.$table.' where '.$where;
            return $query;
        }
    }

    private function generateFind($table,$columns,$conditions){
        $query='select ';
        if(!empty($columns)){
            foreach($columns as $col){
                $query.=$table.'.'.$col.',';
            }
            $query=substr($query,0,strlen($query)-1);
        }
        else{
            $query.='*';
        }
        $query.=' from '.$table;

        if(!empty($conditions)){
            $where=$this->generateCondition($conditions);
            $query.=' where '.$where;
        }
        return $query;
    }

    public function fireQuery($string,$input=null){
        if(stripos($string,'select')!==false||stripos($string,'show')!==false){
            $result=$this->connection->query($string);
            $this->getDbError($this->connection->errorInfo());
            if(!empty($result)){
                $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                return $rows;
            }
            else{
                return 0;
            }
        }
        else{
            $count=$this->connection->exec($string);
            $this->getDbError($this->connection->errorInfo());
            return $count;
        }

    }

    private function generateInsertOrUpdate($table,$data,$condition){
        $query=$this->generateInsert($table,$data,null);
        $query.=' on duplicate key update ';
        foreach($data as $key=>$value){
            $query.=$key.'=';
            $query.='\''.$value.'\',';
        }
        $query=substr($query,0,strlen($query)-1);
        return $query;
    }

    private function generateInsert($table,$data,$condition){
        $query='insert into '.$table.'(';
        $values='values(';
        foreach($data as $key=>$value){
            $query.=$key.',';
            $values.='\''.$value.'\',';
        }
        $query=substr($query,0,strlen($query)-1);
        $values=substr($values,0,strlen($values)-1);
        $query.=')';
        $values.=')';
        $query.=' '.$values;
        return $query;
    }

    private function getDbError($error_arr){
        if(!empty($error_arr)&&!empty ($error_arr[0])&& $error_arr[0]!=0){
            $parent=debug_backtrace();
            $count=count($parent);
            throw new ApplicationException($error_arr[2],$parent[$count-4]['file'],$parent[$count-4]['line']);
        }
    }
}