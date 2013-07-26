<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 22/7/13
 * Time: 3:45 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * Setting of action to particular route
 * All setting are case sensitive.
 * array('method'=>'get','path'=>'/','action'=>'MainController~index');
 * method type can be get,post
 * path can be anything which start from '/'
 * action should be controllername~methodname
 */

$route[]=array('method'=>'get','path'=>'/','action'=>'MainController~index');
$route[]=array('method'=>'get','path'=>'/error','action'=>'ErrorController~error');
$route[]=array('method'=>'get','path'=>'/goto','action'=>'MainController~gotoOther');