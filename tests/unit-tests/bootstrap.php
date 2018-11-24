<?php

define('WP_LIB_EMAIL_DIR', dirname(dirname(__DIR__)));
define('WP_LIB_EMAIL_TEST_DIR', WP_LIB_EMAIL_DIR . '/tests/unit-tests');

require_once( WP_LIB_EMAIL_DIR . '/autoloader.php');#

function esc_html($text) {
	return $text;
}

function __($text){
	return $text;
}

function esc_attr_e($text){
	echo $text;
}

function esc_html__($text){
	echo $text;
}

function esc_html_e($text){
	echo $text;
}

function _e($text){
	return $text;
}

function esc_attr($text){
	return $text;
}

function esc_url($text){
	return $text;
}

function esc_url_raw($text){
	return $text;
}

function esc_textarea($text){
	return $text;
}

function date_i18n($date){
	return $date;
}

function apply_filters($hook, $filteredValue) {
	return $filteredValue;
}


function trailingslashit($path) {
	return rtrim( $path, '/\\' ) . '/';
}

function sanitize_html_class($class) {
	return $class;
}

function get_template_directory() {
	return '/path/to/template-directory/';
}

function get_stylesheet_directory() {
	return '/path/to/stylesheet-directory/';
}

function wp_enqueue_script(){
}

function wp_enqueue_style(){
}

function wp_localize_script(){
}

function rest_url($path){
	return 'www.example.com/wp-json/'.$path;
}
