<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weboniselab
 * Date: 22/7/13
 * Time: 3:45 PM
 * To change this template use File | Settings | File Templates.
 */

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Setting application timezone
date_default_timezone_set('Asia/Kolkata');

// Setting application start time
$config['START_TIME'] = microtime(true);


/**
 * Setting for app path and library path
 * For framework use. Must be defined.
 * Use full absolute paths and end them with '/'      eg. /var/www/project/
 */
$config['APP_PATH'] = realpath('..').'/app/';   /* Give your application name*/
$config['LIB_PATH'] = realpath('..').'/library/';

/**
 * Setting for configuration path
 * Don't change it.
 * It must be this.
 */
$config['CONFIG_PATH'] = $config['APP_PATH'].'protected/config/';

/**
 * Setting for app url
 * Don't change it.
 * It must be this.
 */

$config['APP_URL']='http://'.$_SERVER['SERVER_NAME'].'/';

/**
 * Setting Application Mode
 * for production mode use 'prod'
 * for development mode use 'dev'
 */

$config['APP_MODE'] = 'dev';

/**
 * Setting for Multi Mode
 * By default it is off
 * Enable this mode if your application is used by mobile,pc etc
 * It you want to enable just write 'on'
 */

$config['MULTI_MODE'] = 'off';