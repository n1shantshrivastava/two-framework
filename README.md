
Two Framework Library
=====================

It is a framework library which provides following features.

* Routing
* Session handling
* Database
* Validation
* Request Handling
* Basic Exception Handling

Follow design patterns

* Model View Controller
* Singleton


Requirements
============

* PHP
* Apache Server
* MYSQL

Installation
==========

The package has three parts i.e.

* app
* library
* Readme file

The app folder will contain the actual application code and the library folder has a base functionality code which will be useful for application building.

Download a zip file from 

https://github.com/nishant-shrivastava/two-framework/archive/develop.zip

Extract a zip file and copy the app and library folder in webroot directory.
Give webroot path till app folder

Framework Directory Structure
=============================

- app
	- global			(It will contain all the application asset which will go under respective folder)
		- css
		- flash
		- img
		- js
		- video
	- protected
		- config		(contain configuration of db,route and path etc)
		- controller	(contain all controllers which will extends LibController )
		- model		(contain all models which will extends LibModel )
		- view		(contain all view )
	- .htaccess		(For routing all request towards index.php)
	- index.php		(Entry Point)
- library
	- configuration	(contain classes for setting configurations to application )
	- controller		(contain LibController which has function like make view,render,redirect etc)
	- model			(contain LibModel which provides functionality for managing connections,managing CRUD Operations etc )
	- session		(contain LibSession which has functions like start,destroy,add,update,delete etc )
	- validation		(contain LibValidation which provides validations like required,min,numeric,alphanumeric,special char etc )
	- view			(contain LibView which function like render,make view,redirect etc )
	- Application.php	(contain object of application components like db,session,conf etc )

Configuration
=============

There are three types of configuration
The configuration must be in app/protected/config

* Common configuration
	- It should be in common.conf.php
	- It contain configurations like path,app_mode,multi_mode
	- Setting for app path and library path
	  For framework use. Must be defined.
	  Use full absolute paths and end them with '/'      eg. /var/www/project/
	- Setting Application Mode
	  for production mode use 'prod'
	  for development mode use 'dev'
	- Setting for Multi Mode
	  By default it is off
	  Enable this mode if your application is used by mobile,pc etc
	  It you want to enable just write 'on'

* Database configuration
	- It should be in db.conf.php
	- It contain configurations like host,user,password,db_driver,persistent_connection,charset,collate etc
	- Setting for database configuration

	  Database settings are case sensitive
	  First five parameters are compulsory
	  To set collation and charset of the db connection, use the key 'collate' and 'charset'
	  Default PERSISTENT_CONNECTION is false
	  Default COLLATE is utf8_unicode_ci
	  Default DB_DRIVER is mysql
	  Default CHARSET is utf8
    - for eg. array('HOST'=>'localhost', 'DATABASE'=>'database', 'USER'=>'root', 'PASSWORD'=>'1234', 'DB_DRIVER'=>'mysql',  'PERSISTENT_CONNECTION'=>true, 'COLLATE'=>'utf8_unicode_ci', 'CHARSET'=>'utf8');

* Route configuration
	- It should be in route.conf.php
	- All setting are case sensitive.
	- It contain configurations like method type,path,action etc
	- The Route configuration can be done by two ways.First way for normal urls and second way for smart urls.
	- Setting for normal urls

	  $route[]=array('method'=>'get','path'=>'/','action'=>'Main~index');

	  Here,
	  method type can be get,post
	  path can be anything which start from '/'
	  action should be controller_name~method_name
	- Setting for smart urls

	  $route[]=array('method'=>'get','path'=>'/profile/[id]','action'=>'Main~profile');

	  Here,
	  method type can be get,post
	  path can be anything which start from '/'
	  In path, the last part should be in square bracket containing a variable name
	  The variable can be accessible in method by respective global array means If method type is get then $_GET and If method type is post then $_POST
	  action should be controller_name~method_name

Building Controller
===================

    - The controller must extend LibController class
    - The controller name should be in capital case
      for eg. UserController
    - The controller name must have 'Controller' postfix
    - All controller methods should be in camel case
    - It should be create in app/protected/controller
    - Example

      class MainController extends LibController{
          public function index(){
                // do your stuff
          }
      }

Building Model
==============

    - The model must extend LibModel class
    - The model name should be in capital case
      for eg. UserModel
    - The model name must have 'Model' postfix
    - All model methods should be in camel case
    - It should be create in app/protected/model
    - Each model will be associated with only one table
    - If table name is not mentioned then model name will be taken as table name (for eg. UserModel will have user table)
    - Primary key of the table should be 'id'. If you want to change it you can set $primaryKey variable.
    - Example

      class UserModel extends LibModel{
            // do your stuff
      }

Building View
=============

    - The view name should be in capital case
      for eg. UserView
    - The view name must have 'View' postfix
    - It should be create in app/protected/view

Routing
=======

	- It should define in route.conf.php
	- Routing can be done by three ways
	- First:(Normal url)
	    Syntax for adding new route is

		$route[]=array('method'=>'get','path'=>'/','action'=>'Main~index');

		Here,
		method can be get,post
		path should be start from '/'
		action should be controller_name~method_name
	- Second:(Smart url)
	    Syntax for adding new route is

		$route[]=array('method'=>'get','path'=>'/profile/[id]','action'=>'Main~profile');

       Here,
	   method type can be get,post
	   path can be anything which start from '/'
	   In path, the last part should be in square bracket containing a variable name
	   The variable can be accessible in method by respective global array means If method type is get then $_GET and If method type is post then $_POST
	   action should be controller_name~method_name
	-Third:(Direct url) You can call a request which are not configured but has perfect controller name and method name like as follows

		eg.1) /User 
				- It will try to call index method of UserController
		eg.2) /User/Add
				- It will try to call Add method of UserController

    - You can send url parameters like as follow

        /User?uname=swpanil&age=23&city=pune
        /User/add?uname=swpanil&age=23&city=pune

	- If requested url is not present in route.conf.php and also it is not correct then error is thrown like
		No action is bind to this url /maindsf/sdf/sdf for GET method

Database Handling
=================

You can do database handling by following method
	- insertData( array $data)

	  inserts $data into table,$data will be key-value pair of field-of-table and value
    - updateData( array $data, array $condition)

      updates data on specified $conditions
	- deleteData( array $condition)

	  deletes data on specified conditions.
	- findAll()

	  gives all record from table;
	- findSpecified( array $column,[array $condition])

	  gives only specified columns as result, you can give condition if you want.
	- findByCondition( array $condition ,[array $column])

	  gives rows which satisfied conditions, you can specify columns in second optional argument
	- query(string $queryString)

	  you can directly fire your query using this function;
	- save()

	  insert the data with object of model,if data with same primary key is present then it will be updated
	  for eg.
	        $user=new UserModel();
	        $user->id=1
			$user->name='tom';
			$user->save();

    - Rules for condition array:

	  any condition will be in form of operand,operator,operand,
      so condition must be array of 3. if you want more than on condition you can replace  operand with array of condition like,
      array( array('a','>','20'),'and',array('b','in',array(1,2,3,4))) will be equivalent to 'where a > 20 and b in (1,2,3,4)'
      supported operators  are = >,>=,<,<=,and,or,in,not in,like,not like

Session Handling
================

You can do session handling by following method

        Application::session()->start();
        Application::session()->destroy();
        Application::session()->write(variable_name,value);
        Application::session()->delete(variable_name);
        Application::session()->modify(variable_name,value);
        Application::session()->read(variable_name);
        Application::session()->readAll();

    - The variable_name should not be empty.

Validation
==========

	- Rules are predefined for validation
	- Developers will use those rule to validate the data
 	- If any rule is not given by default require rule will be use for all mentioned data fields
	- Rules are defined and must be given in the defined way
	- Rules are as follows :
		1) require -> field should not be empty
		2) alpha -> field should contain 'only alphabets'
		3) alphanumeric -> field should contain 'only alphanumeric' characters
		4) numeric -> field should contain 'only numeric' values
		5) email -> validate the email
		6) numeric-> field should contain numeric data only
		7) special -> validate occurrence of special character.these character are !@#$%^&*.(at least one special character must be present);
		          if you want to exclude any character you can mention it with ':' Eg 'special:@' will not consider @ as special character
		8) min -> validate field with min character length. Length must be specified with prefix ':'.if length is not mentioned 5 is default value.
			      eg. 'min:5'
		9) max -> validate field with maximum character length. Length will specified same as min.

	- Please do not use two contradictory rules together (like alpha and numeric)

	- For validation class usage create object of it as follow

	        $data=array('name'=>'asdfa','email'=>'abc@pqr.com');

            $valid=new LibValidation($data,array('name'=>array('require','special:@','min:5'),'email'=>array('email','require')));

            First parameter is data array in key->value pair and second parameter is rule array in key->value pair.

            By using validate method, you can validate details like as follow

                    if(!$valid->validate()){
                        $data_to_render=array('error_field'=>$valid->error_field,'validation_errors'=>$valid->validation_errors);
                        $this->render('userError',$data_to_render);
                    }
                    else{
                        $this->render('new',$data);
                    }