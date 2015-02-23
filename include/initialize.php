<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

define('SITE_ROOT', DS.'Applications'.DS.'AMPPS'.DS.'www'.
					DS.'mikart'.DS.'webfile');

define('PUB_PATH',SITE_ROOT.DS.'public');
define('INC_PATH', SITE_ROOT.DS.'include');

require_once(INC_PATH.DS.'db_connection.php');
require_once(INC_PATH.DS.'database_object.php');
require_once(INC_PATH.DS.'admin.php');
require_once(INC_PATH.DS.'session.php');
require_once(INC_PATH.DS.'session_customer.php');
require_once(INC_PATH.DS.'helper.php');
?>