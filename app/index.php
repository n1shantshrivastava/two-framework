<?php
// Set application paths here
include './protected/config/common.conf.php';

include $config['LIB_PATH'].'Application.php';

Application::conf()->setConfiguration($config);

include $config['CONFIG_PATH'].'routes.conf.php';
include $config['CONFIG_PATH'].'db.conf.php';

Application::db()->setConfiguration($dbconfig);

Application::setRouting($route);

Application::run();

Application::shutDown();