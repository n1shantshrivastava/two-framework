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
        $view=ucfirst($view);
        $view.='View';
        $fileName=Application::conf()->APP_PATH.'protected/view/'.$view.'.php';
        if(file_exists($fileName)){
            require_once $fileName;
        }
        else
        {
            throw new ApplicationException("View not found",__FILE__,__LINE__);
        }
    }
}