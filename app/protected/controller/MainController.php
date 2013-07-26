<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 24/7/13
 * Time: 3:45 PM
 * To change this template use File | Settings | File Templates.
 */
class MainController extends LibController{
    public function index(){
      //  echo 'hello';
        $data=array('name'=>'Priyanka_Bhoir','email'=>'abc@pqr.com');
        $this->render('new',$data);

    }
    public function gotoOther(){
        $this->redirect('/error');
    }
}