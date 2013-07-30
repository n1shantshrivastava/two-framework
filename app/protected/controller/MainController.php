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
        $data=array('fname'=>'aarti','email_id'=>'abc@pqr.com');

        /*$valid=new LibValidation($data,array('name'=>array('require','special:@','min:5','alphanumeric'),'email'=>array('email','require')));
        if(!$valid->validate()){
            $data_to_render=array('error_field'=>$valid->error_field,'validation_errors'=>$valid->validation_errors);
            $this->render('userError',$data_to_render);
        }
        else{
            $this->render('new',$data);
        }*/

        $model=new UserModel();
        $model->insert(array('id'=>'24','fname'=>'xyz'));
        $rows=$model->getAll();
        $condition=array(array('id','in',array(1,2,3,4,5,6,7)),'and',array('city','=','pune'));
        $rows=$model->getByCondition($condition);
        /*if(is_array($rows)){
            $this->render('new',array("rows"=>$rows));
        }*/
        $condition=array('id','=','12');
        /*$rows=$model->getByCondition($condition);
        if(is_array($rows)){
            $this->render('new',array("rows"=>$rows));
        }*/
        $model->update($data);
        $str=$model->delete($condition);
        $arg='priyanka';
        $model->query("select * from user where id ='1'");
        if(is_array($rows)){
            $this->render('new',array("rows"=>$rows));
        }
    }

    public function gotoOther(){
        $this->redirect('/error');
    }
}