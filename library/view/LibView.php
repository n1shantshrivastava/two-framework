<?php
class LibView{

    public function __set($key,$value){
        $this->{$key}=$value;
    }
    /*
     * render the given view
     * the view will be included  so that it will be available to send to browser
     */
    public function render($view){
        $fileName=Application::conf()->APP_PATH.'/protected/view/'.$view.'.php';
        if(file_exists($fileName)){
            include $fileName;
        }
    }
}