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
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(isset($_SESSION)){
            if(empty($_SESSION))
            {
                $this->is_enable=false;
                $this->session_id=null;
            }
            else{
                $this->start();
            }
        }
    }

    public function start(){
        try{
            if(!$this->is_enable){
                if(!isset($_SESSION)){
                    if(session_start()){
                        $this->session_id=session_id();
                        $this->is_enable=true;
                    }
                    else{
                        $parent=debug_backtrace();
                        throw new ApplicationException('Session not started',$parent[0]['file'],$parent[0]['line']);
                    }
                }
                else{
                    $this->session_id=session_id();
                    $this->is_enable=true;
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
                    $parent=debug_backtrace();
                    throw new ApplicationException('Session not destroyed',$parent[0]['file'],$parent[0]['line']);
                }
            }
            else{
                if(empty($_SESSION)){
                    session_unset();
                    if(session_destroy()){
                        $this->session_id=session_id();
                        $this->is_enable=false;
                    }
                    else{
                        $parent=debug_backtrace();
                        throw new ApplicationException('Trying to destroy uninitialized session',$parent[0]['file'],$parent[0]['line']);
                    }
                }
            }
        }
        catch(Exception $e){

        }
    }

    public function write($variable_name,$value){
        try{
            if($this->is_enable){
                if($variable_name!==''){
                    if(!isset($_SESSION[$variable_name])){
                        $_SESSION[$variable_name]=$value;
                    }
                    else{
                        $parent=debug_backtrace();
                        throw new ApplicationException('Session variable already added',$parent[0]['file'],$parent[0]['line']);
                    }
                }
                else{
                    $parent=debug_backtrace();
                    throw new ApplicationException('Session variable should not be empty',$parent[0]['file'],$parent[0]['line']);
                }
            }
            else{
                $parent=debug_backtrace();
                throw new ApplicationException('Session is not started',$parent[0]['file'],$parent[0]['line']);
            }
        }
        catch(Exception $e){

        }
    }

    public function delete($variable_name){
        if($this->is_enable){
            if($variable_name!==''){
                if(!isset($_SESSION[$variable_name])){
                    unset($_SESSION[$variable_name]);
                }
                else{
                    $parent=debug_backtrace();
                    throw new ApplicationException('Session variable is not set',$parent[0]['file'],$parent[0]['line']);
                }
            }
            else{
                $parent=debug_backtrace();
                throw new ApplicationException('Session variable should not be empty',$parent[0]['file'],$parent[0]['line']);
            }
        }
        else{
            $parent=debug_backtrace();
            throw new ApplicationException('Session is not started',$parent[0]['file'],$parent[0]['line']);
        }
    }

    public function modify($variable_name,$value){
        try{
            if($this->is_enable){
                if($variable_name!==''){
                    if(!isset($_SESSION[$variable_name])){
                        $_SESSION[$variable_name]=$value;
                    }
                    else{
                        $parent=debug_backtrace();
                        throw new ApplicationException('Session variable is not set',$parent[0]['file'],$parent[0]['line']);
                    }
                }
                else{
                    $parent=debug_backtrace();
                    throw new ApplicationException('Session variable should not be empty',$parent[0]['file'],$parent[0]['line']);
                }
            }
            else{
                $parent=debug_backtrace();
                throw new ApplicationException('Session is not started',$parent[0]['file'],$parent[0]['line']);
            }
        }
        catch(Exception $e){

        }
    }

    public function read($variable_name){
        try{
            if($this->is_enable){
                if($variable_name!==''){
                    if(isset($_SESSION[$variable_name])){
                        return $_SESSION[$variable_name];
                    }
                    else{
                        $parent=debug_backtrace();
                        throw new ApplicationException('Session variable not set',$parent[0]['file'],$parent[0]['line']);
                    }
                }
                else{
                    $parent=debug_backtrace();
                    throw new ApplicationException('Session variable should not be empty',$parent[0]['file'],$parent[0]['line']);
                }
            }
            else{
                $parent=debug_backtrace();
                throw new ApplicationException('Session is not started',$parent[0]['file'],$parent[0]['line']);
            }
        }
        catch(Exception $e){

        }
    }

    public function readAll(){
        try{
            if($this->is_enable){
                return $_SESSION;
            }
            else{
                $parent=debug_backtrace();
                throw new ApplicationException('Session is not started',$parent[0]['file'],$parent[0]['line']);
            }
        }
        catch(Exception $e){

        }
    }
}