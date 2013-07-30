
Two Framework Library
=================

It is a framework library which provides following features.

1) Routing
2) Session handling
3) Database
4) Validation
5) Request Handling
6) Basic Exception Handling

Follow design patterns

1) Model View Controller 
2) Singleton 


REQUIREMENTS
============

* PHP
* Apache Server
* MYSQL

INSTALLATION
==========

The package has three parts i.e.

1) app
2) library
3) Readme file

The app folder will contain the actual application code and the library folder has a base functionality code which will be useful for application building.

Download a zip file from 

https://github.com/nishant-shrivastava/two-framework/archive/develop.zip

Extract a zip file and copy the app and library folder in webroot directory.
Give webroot path till app folder

FRAMEWORK DIRECTORY STRUCTURE
===========================

-app
	-global			(It will contain all the application asset which will go under respective folder)
		-css
		-flash
		-img
		-js
		-video
	-protected
		-config		(contain configuration of db,route and path etc)		
		-controller	(contain all controllers which will extends LibController )
		-model		(contain all models which will extends LibModel )
		-view		(contain all view )
	.htaccess		(For routing all request towards index.php)	
	index.php		(Entry Point)
-library
	-configuration	(contain classes for setting configurations to application )
	-controller		(contain LibController which has function like make view,render,redirect etc)
	-model			(contain LibModel which provides functionality for managing connections,managing CRUD Operations etc )
	-session		(contain LibSession which has functions like start,destroy,add,update,delete etc )
	-validation		(contain LibValidation which provides validations like required,min,numeric,alphanumeric,special char etc )
	-view			(contain LibView which function like render,make view,redirect etc )
	Application.php	(contain object of application components like db,session,conf etc )

CONFIGURATION
=============

There are three types of configuration
The configuration must be in app/protected/config

1) Common configuration
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

2) Database configuration
	- It should be in db.conf.php
	- It contain configurations like host,user,password,db_driver,persistent_connection,charset,collate etc
	- Setting for database configuration
	  Database settings are case sensitive.
	  First five parameters are compulsory.
	  To set collation and charset of the db connection, use the key 'collate' and 'charset'
	  Default PERSISTENT_CONNECTION is false
	  Default COLLATE is utf8_unicode_ci
	  Default DB_DRIVER is mysql
	  Default CHARSET is utf8
	  for eg. array('HOST'=>'localhost', 'DATABASE'=>'database', 'USER'=>'root', 'PASSWORD'=>'1234', 'DB_DRIVER'=>'mysql',  'PERSISTENT_CONNECTION'=>true, 'COLLATE'=>'utf8_unicode_ci', 'CHARSET'=>'utf8');	

3) Route configuration
	- It should be in route.conf.php
	- It contain configurations like method type,path,action etc
	- Setting of action to particular route
	  All setting are case sensitive.
	  array('method'=>'get','path'=>'/','action'=>'Main~index');
	  method type can be get,post
	  path can be anything which start from '/'
	  action should be controller_name~method_name

BUILDING CONTROLLER
===================

1) The controller must extend LibController class
2) The controller name should be in capital case
   for eg. UserController
3) The controller name must have 'Controller' postfix
4) All controller methods should be in camel case
5) It should be create in app/protected/controller

BUILDING MODEL
==============

1) The model must extend LibModel class
2) The model name should be in capital case
   for eg. UserModel
3) The model name must have 'Model' postfix
4) All model methods should be in camel case
5) It should be create in app/protected/model

BUILDING VIEW
==============

1) The view name should be in capital case
   for eg. UserView
2) The view name must have 'View' postfix
3) It should be create in app/protected/view

ROUTING
=======

	- It should define in route.conf.php
	- Sytax for it
		$route[]=array('method'=>'get','path'=>'/','action'=>'Main~index');
		
		method can be get,post
		path should be start from '/'
		action contain controller_name~method_name
	- You can call a request which are not configured but has perfect controller name and method name like as follows

		eg.1) /User 
				- It will try to call index method of UserController
		eg.2) /User/Add
				- It will try to call Add method of UserController

    - You can send url parameters like as follow

        /User/add?uname=swpanil&age=23&city=pune

	- If requested url is not present in route.conf.php and also it is not correct then error is thrown like
		No action is bind to this url /maindsf/sdf/sdf 

SESSION HANDLING
================

You can do session handling by following method

        Application::session()->start();
        Application::session()->destroy();
        Application::session()->add(variable_name,value);
        Application::session()->delete(variable_name);
        Application::session()->update(variable_name,value);

    - The variable_name should not be empty.

VALIDATION
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