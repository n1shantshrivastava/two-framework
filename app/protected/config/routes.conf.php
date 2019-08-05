<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 22/7/13
 * Time: 3:45 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * Setting normal url
 * All setting are case sensitive.
 * array('method'=>'get','path'=>'/','action'=>'Main~index');
 * method type can be get,post
 * path can be anything which start from '/'
 * action should be controller_name~method_name
 */

/**
 * Setting for smart urls
 * $route[]=array('method'=>'get','path'=>'/profile/[id]','action'=>'Main~profile');
 * method type can be get,post
 * path can be anything which start from '/'
 * In path, the last part should be in square bracket containing a variable name
 * The variable can be accessible in method by respective global array means If method type is get then $_GET and If method type is post then $_POST
 * action should be controller_name~method_name
 */

$route[]=array('method'=>'get','path'=>'/','action'=>'Main~index');
$route[]=array('method'=>'get','path'=>'/error','action'=>'Error~error');
$route[]=array('method'=>'get','path'=>'/goto','action'=>'Main~gotoOther');
$route[]=array('method'=>'get','path'=>'/profile/[id]','action'=>'Main~profile');

