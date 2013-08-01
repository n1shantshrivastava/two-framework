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
        /*
         * -----------------Validation-------------------------------
         $data=array('fname'=>'aarti','email_id'=>'abc@pqr.com');

        $valid=new LibValidation($data,array('name'=>array('require','special:@','min:5','alphanumeric'),'email'=>array('email','require')));
        if(!$valid->validate()){
            $data_to_render=array('error_field'=>$valid->error_field,'validation_errors'=>$valid->validation_errors);
            $this->render('userError',$data_to_render);
        }
        else{
            $this->render('new',$data);
        }*/

        /*
         * -------------------- insert ----- findByCondition----------------
        $model=new UserModel();
        $model->insert(array('id'=>'24','fname'=>'xyz'));
        $rows=$model->getAll();

        $model=new UserModel();
        $condition=array(array('id','in',array(1,2,3,4,5,6,7)),'and',array('city','=','pune'));
        $rows=$model->getByCondition($condition);
        if(is_array($rows)){
            $this->render('new',array("rows"=>$rows));
        }
        */

        /*
         *
        $condition=array('id','=','12');
        $rows=$model->getByCondition($condition);
        if(is_array($rows)){
            $this->render('new',array("rows"=>$rows));
        }*/

        /*
         *
         * ------------- update --------------
        $model=new UserModel();
        $condition=array('id','=','12');
        $data=array('fname'=>'aarti','email_id'=>'anana@pqr.com');
        $model->updateData($data,$condition);
        */

        /*
         * ------------ delete ---------------------
        $model=new UserModel();
        $condition=array('id','=','12');
        $model->deleteData($condition);
        */


         //* -------------- query ----------------------
        /*
        $model=new UserModel();
        $rows=$model->query("select * from user where id < '6'");
        if(is_array($rows)){
            $this->render('new',array("rows"=>$rows));
        }
        */


        $user=new UserModel();
        /*
         * ------------ save() ----------------------
        $user->id=10;
        $user->fname='qwe';
        $user->lname='qwe';
        $user->email_id='wqewr@gmail.com';
        $user->save();                      //inserts record(id=10) to database
        $user->fname='minal';

        $user->save();                      // updates the record(id=10)
        $user->deleteData();                //deletes record(id=10)
        */

    }

    public function gotoOther(){
        $this->redirect('/error');
    }
    public function newRecord(){
        $user=new UserModel();
        $user->id=100;
        $user->fname='qwe';
        $user->lname='qwe';
        $user->email_id='wqewr@gmail.com';
        $user->save();                      //inserts record(id=10) to database

        $condition=array('id','=','100');
        $rows=$user->getByCondition($condition);
        if(is_array($rows)){
            $this->render('new',array("rows"=>$rows));
        }
        /*
        $user->fname='minal';
        $user->save();

        $condition=array('id','=','99');
        $rows=$user->getByCondition($condition);
        if(is_array($rows)){
            $this->render('new',array("rows"=>$rows));
        }
        */
    }
}