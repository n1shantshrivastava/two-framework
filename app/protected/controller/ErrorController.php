<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 26/7/13
 * Time: 3:39 PM
 * To change this template use File | Settings | File Templates.
 */

class ErrorController extends LibController{
    public function index(){
        $this->render('Error',Application::$error);
    }
    public function error(){
        $this->render('error');
    }
}