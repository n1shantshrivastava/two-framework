<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 23/7/13
 * Time: 12:29 PM
 * To change this template use File | Settings | File Templates.
 */

class LibConfiguration{

    public $APP_MODE;

    public $START_TIME;

    public $APP_PATH;

    public $LIB_PATH;

    public $CONFIG_PATH;

    public $MULTI_MODE;

    public $APP_URL;

    public function __construct(){
        $this->APP_MODE='';
        $this->START_TIME=null;
        $this->APP_PATH='';
        $this->LIB_PATH='';
        $this->CONFIG_PATH='';
        $this->MULTI_MODE='';
        $this->APP_URL='';
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    public function setConfiguration($confArr){
        foreach($confArr as $k=>$v){
            $this->$k = $v;
        }
    }

    public function __destruct(){
        $this->APP_MODE='';
        $this->START_TIME=null;
        $this->APP_PATH='';
        $this->LIB_PATH='';
        $this->CONFIG_PATH='';
        $this->MULTI_MODE='';
        $this->APP_URL='';
    }
}