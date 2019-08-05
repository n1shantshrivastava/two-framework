<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 23/7/13
 * Time: 6:06 PM
 * To change this template use File | Settings | File Templates.
 */

class LibDBConfiguration{

    public $HOST;

    public $DATABASE;

    public $USER;

    public $PASSWORD;

    public $DB_DRIVER;

    public $PERSISTENT_CONNECTION;

    public $COLLATE;

    public $CHARSET;

    public function __construct(){
        $this->HOST='';
        $this->DATABASE='';
        $this->USER='';
        $this->PASSWORD='';
        $this->DB_DRIVER='mysql';
        $this->PERSISTENT_CONNECTION=false;
        $this->COLLATE='utf8_unicode_ci';
        $this->CHARSET='utf8';
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    public function setConfiguration($dbconfig){
        foreach($dbconfig as $k=>$v){
            $this->$k = $v;
        }
    }

    public function __destruct(){
        $this->HOST='';
        $this->DATABASE='';
        $this->USER='';
        $this->PASSWORD='';
        $this->DB_DRIVER='';
        $this->PERSISTENT_CONNECTION=null;
        $this->COLLATE='';
        $this->CHARSET='';
    }
}