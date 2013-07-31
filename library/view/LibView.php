<?php
class LibView{
    /*
     * title of the page
     */
    public $title;
    public function __set($key,$value){
        $this->{$key}=$value;
    }
    /*
     * render the given view
     * the view will be included  so that it will be available to send to browser
     */
    public function render($view,$className){

        $this->title=$view;
        $view=ucfirst($view);
        $view.='View';
        $className=strstr($className,'Controller',true);
        $fileName=Application::conf()->APP_PATH.'protected/view/'.$className.'/'.$view.'.php';
        if(file_exists($fileName)){
            require_once $fileName;
            $this->unsetAll();
        }
        else
        {
            throw new ApplicationException("View not found",__FILE__,__LINE__);
        }
    }
   public function fetch($file){
       $fileName=Application::conf()->APP_PATH.'protected/view/common/'.$file.'.php';
       if(file_exists($fileName)){
           require_once $fileName;
       }
   }
   private function unsetAll(){
      foreach($this as $key=>$value){
          unset($this->{$key});
      }
   }
}