<?php

//Defines the data location for tests
define('WP_LIB_EMAIL_TEST_DIR', dirname(__FILE__));

//Load the test library...
$_tests_dir = getenv('WP_TESTS_DIR');
if ( !$_tests_dir ) $_tests_dir = '/tmp/wp-test-library/';
require_once $_tests_dir . '/includes/functions.php';

tests_add_filter( 'muplugins_loaded', function(){
	require dirname( __FILE__ ) . '/../../autoloader.php';
});


require $_tests_dir . '/includes/bootstrap.php';

spl_autoload_register(function ($class) {

	 $prefix = 'IntegrationTests\\';
	 $base_dir = WP_LIB_EMAIL_TEST_DIR . '/';

	 if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
			 return;
	 }

	 $relative_class = substr($class, strlen($prefix));
	 $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	 if (file_exists($file)) {
			 require $file;
	 }
});

require 'mockMailer.php';
