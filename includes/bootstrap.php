<?

require 'vendor/autoload.php';
require_once('functions.php');

date_default_timezone_set('Australia/Sydney');

function classloader($className){
	$files = glob("src/Store/*.php");

	foreach ($files as $key => $file) {
		if(basename($file) == $className . '.php') {
			include_once($file);
			break;
		}
	}
}

spl_autoload_register('classloader');

function handleErrors($e) {
	//log your errors to logging server
}

function handleExceptions($e){
	try {
		// log errors here
	} catch (Exception $e){
		header('Content-type: text/plain');
		print_r(debug_backtrace());
		print get_class($e)." thrown within the exception handler. Message: ".$e->getMessage()." on line ".$e->getLine();
	}
}

set_error_handler("handleErrors");
set_exception_handler("handleExceptions");