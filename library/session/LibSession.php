<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 23/7/13
 * Time: 6:12 PM
 * To change this template use File | Settings | File Templates.
 */

class LibSession{
    public $is_enable;

    public $session_id;

    public function __construct(){
        $this->is_enable=false;
        $this->session_id=null;
        if(!isset($_SESSION))
        $this->start();
    }

    public function start(){
        try{
            if(!$this->is_enable){
                if(session_start()){
                    $this->session_id=session_id();
                    $this->is_enable=true;
                }
                else{
                    throw new ApplicationException('Session not started',__FILE__,__LINE__);
                }
            }
        }
        catch(Exception $e){

        }
    }

    public function destroy(){
        try{
            if($this->is_enable){
                session_unset();
                if(session_destroy()){
                    $this->session_id=session_id();
                    $this->is_enable=false;
                }
                else{
                    throw new ApplicationException('Session not destroyed',__FILE__,__LINE__);
                }
            }
            else{
                throw new ApplicationException('Trying to destroy uninitialized session',__FILE__,__LINE__);
            }
        }
        catch(Exception $e){

        }
    }

    public function add($variable_name,$value){
        try{
            if($this->is_enable){
                $_SESSION[$variable_name]=$value;
            }
            else{
                throw new ApplicationException('Session variable not added',__FILE__,__LINE__);
            }
        }
        catch(Exception $e){

        }
    }

    public function delete($variable_name){
        if($this->is_enable){
            unset($_SESSION[$variable_name]);
        }
        else{
            throw new ApplicationException('Session variable not deleted',__FILE__,__LINE__);
        }
    }

    public function update($variable_name,$value){
        try{
            if($this->is_enable){
                $_SESSION[$variable_name]=$value;
            }
            else{
                throw new ApplicationException('Session variable not updated',__FILE__,__LINE__);
            }
        }
        catch(Exception $e){

        }
    }

    public function get($variable_name){
        try{
            if(isset($_SESSION[$variable_name])){
                return $_SESSION[$variable_name];
            }
            else{
                throw new ApplicationException('Session variable not set',__FILE__,__LINE__);
            }
        }
        catch(Exception $e){

        }
    }
}