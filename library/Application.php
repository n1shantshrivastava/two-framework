<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 22/7/13
 * Time: 3:40 PM
 * To change this template use File | Settings | File Templates.
 */

spl_autoload_register(array('Application', 'libAutoload'));

class Application{
    protected static $_conf=null;
    protected static $_db=null;
    protected static $_session=null;

    protected static $app_type='';
    protected static $route=array();
    public static $error=null;

    public static function setRouting($route){
        self::$route=$route;
    }

    public static function run(){
        if(self::conf()->MULTI_MODE==='on'){
            if(self::isMobile()){
                self::$app_type='mobile';
            }
            else{
                self::$app_type='pc';
            }
        }

        self::dispatch();
    }

    public static function dispatch(){
        try{
            $sub_folder=str_replace($_SERVER['DOCUMENT_ROOT'],'',self::conf()->APP_PATH);
            $sub_folder=substr($sub_folder,0,strlen($sub_folder)-1);
            $request_url=str_replace($sub_folder,'',$_SERVER['REQUEST_URI']);
            $url_parts=explode('?',$request_url);
            $request_url=$url_parts[0];

            for($cnt=0;$cnt<count(self::$route);$cnt++){
                if(strcasecmp(self::$route[$cnt]['method'],$_SERVER['REQUEST_METHOD'])==0 && strcasecmp(self::$route[$cnt]['path'],$request_url)==0){
                    list($controller_name,$method_name)=explode('~',self::$route[$cnt]['action']);
                    $contObj=new $controller_name();
                    if(method_exists($contObj,$method_name)){
                        $contObj->$method_name();
                        break;
                    }
                    else{
                        throw new ApplicationException($method_name.' method does not exist in '.$controller_name.' controller',__FILE__,__LINE__);
                    }
                }
            }

            if($cnt==count(self::$route)){
                throw new ApplicationException('No action is bind to this url '.$request_url,__FILE__,__LINE__);
            }
        }
        catch(Exception $e){

        }

    }

    public static function shutDown(){
        if(isset(self::$error)){
            $obj=new ErrorController();
            $obj->index();
        }
        self::$_conf=null;
        self::$_db=null;
        self::$app_type='';
        self::$route=array();
        if(isset(self::$error)){
            self::$error=null;
            exit;
        }
    }

    public static function isMobile() {
        $is_mobile = 0;

        if(isset($_SERVER['HTTP_USER_AGENT'])){
            if(preg_match('/(android|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                $is_mobile=1;
            }

            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows')>0) {
                $is_mobile=0;
            }

            $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));

            $mobile_agents = array('w3c ','acs-','alav','alca','amoi','andr','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');

            if(in_array($mobile_ua,$mobile_agents)) {
                $is_mobile=1;
            }
        }

        if(isset($_SERVER['HTTP_ACCEPT'])){
            if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
                $is_mobile=1;
            }
        }

        if (isset($_SERVER['ALL_HTTP'])) {
            if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini')>0) {
                $is_mobile=1;
            }
        }

        return $is_mobile;
    }


    public static function conf(){
        if(self::$_conf==null){
            self::$_conf=new LibConfiguration();
        }

        return self::$_conf;
    }

    public static function db(){
        if(self::$_db==null){
            self::$_db=new LibDBConfiguration();
        }

        return self::$_db;
    }

    public static function session(){
        if(self::$_session==null){
            self::$_session=new LibSession();
        }

        return self::$_session;
    }

    public static function libAutoload($class_name){
        try{
            if(self::$_conf!=null && strpos($class_name,'Lib')===0){
                $lib_path=self::conf()->LIB_PATH;
                if(file_exists($lib_path."configuration/$class_name.php"))
                    require_once $lib_path ."configuration/$class_name.php";
                elseif(file_exists($lib_path ."controller/$class_name.php"))
                    require_once $lib_path."controller/$class_name.php";
                elseif(file_exists($lib_path ."model/$class_name.php"))
                    require_once $lib_path."model/$class_name.php";
                elseif(file_exists($lib_path ."view/$class_name.php"))
                    require_once $lib_path."view/$class_name.php";
                elseif(file_exists($lib_path ."session/$class_name.php"))
                    require_once $lib_path."session/$class_name.php";
                elseif(file_exists($lib_path ."validation/$class_name.php"))
                    require_once $lib_path."validation/$class_name.php";
                else
                    throw new ApplicationException($class_name.' class does not exist',__FILE__,__LINE__);
            }
            elseif(self::$_conf!=null && strpos($class_name,'Lib')==false){
                $app_path=self::conf()->APP_PATH;
                if(file_exists($app_path."protected/controller/$class_name.php"))
                    require_once $app_path."protected/controller/$class_name.php";
                elseif(file_exists($app_path."protected/model/$class_name.php"))
                    require_once $app_path."protected/model/$class_name.php";
                elseif(file_exists($app_path."protected/view/$class_name.php"))
                    require_once $app_path."protected/view/$class_name.php";
                else
                    throw new ApplicationException($class_name.' class does not exist',__FILE__,__LINE__);
            }
            elseif(self::$_conf==null && $class_name=='LibConfiguration'){
                require_once "configuration/$class_name.php";
            }
        }
        catch(Exception $e){

        }
    }
}

class ApplicationException extends Exception
{
    public function __construct($msg,$file_name,$line_no){
        Application::$error=array('msg'=>$msg,'file_name'=>$file_name,'line_no'=>$line_no);
        Application::shutDown();
    }
}