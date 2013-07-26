<?php



class LibController{
    public $view;
    /* public function load($className){
        return new $className;
     }
     */
    public function render($full_path,$data=null){
        if(is_array($data)){
            foreach($data as $key=>$value){
                $this->makeView()->$key=$value;
            }
        }
        $this->makeView()->render($full_path);
    }

     /*
      * redirects  to the specified path
      * it will discard the current view of your browser and routes to the action for given path
      */
    public function redirect($path){
        $path=$this->generateUrl($path);
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$path.'">';
    }

    /*
     * this method will generate the url to your specified path
     * if path is /user then actually it need to hit www.my_web.com/user
     * this is done by following method
     */
    private function generateUrl($path){
        $app_path=Application::conf()->APP_URL;
        $sub_folder=str_replace($_SERVER['DOCUMENT_ROOT'],'',Application::conf()->APP_PATH);
        $sub_folder=substr($sub_folder,0,strlen($sub_folder)-1);
        if($sub_folder===''){
            $app_path=substr($app_path,0,strlen($app_path)-1);
        }
        return($app_path.$sub_folder.''.$path);
    }

    /*
     * this method will create the object of the view class if not already present
     */
    private function makeView(){
        if(!isset($this->view)){
            $this->view=new LibView();
        }
        return $this->view;
    }

}
