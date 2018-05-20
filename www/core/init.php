<?php
ob_start();
session_start();

// ERROR REPORTING 
error_reporting(~E_WARNING);

define( 'ROOT', dirname(dirname(__FILE__)) );
define( 'DS' , DIRECTORY_SEPARATOR);
define( 'DEBUG' , 0);
define( 'EXT' , '.php');
define( 'CSS' , '.css');
define( 'JS' , '.js');
define( 'START_DIR', 'public');

$GLOBALS['general'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'imageboard',
		'prefix' => 'th_'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'lang' => array(
		'cookie_name' => '_lang',
		'cookie_expiry' => 604800,
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	),
);



require_once ROOT . '/core/sanitize.php';



spl_autoload_register(function($class){
		if( !strcmp($class, "Hash") )
			require_once  ROOT  .'/classes/class.'. $class . '.php';
		else
			require_once  ROOT  .'/classes/class.'. strtolower($class) . '.php';
});
 
// AFTER LOAD CLASS 

$GLOBALS['tables'] = array(
		'name' => array(
			'users' => config::get('general','mysql/prefix').'users',
			'users_session' =>  config::get('general','mysql/prefix').'users_session',
			'groups' => config::get('general','mysql/prefix').'groups',
			'comments' => config::get('general','mysql/prefix').'comments',
			'category' => config::get('general','mysql/prefix').'category', 
			'posts' => config::get('general','mysql/prefix').'posts',
			'adverts' => config::get('general','mysql/prefix').'adverts',
			'report' => config::get('general','mysql/prefix').'report',
			'hashtag' => config::get('general', 'mysql/prefix') . 'hashtag',
			'page' => config::get('general', 'mysql/prefix') . 'page'
		)
);

$page = new page(); $page->get(); // PAGE INFO

$lang = new lang();
$user = new user(); // USER INFO
$template = new template();
$category = new category(); $category->getAll();
$advertising = new adverts();
$wall = new posts();
$secure = new secure();
$pagination = new pagination();
$reports = new report();


// PRE DEFINED
$template->category = $category;
$template->advertising = $advertising;
$template->user = $user;
$template->wall = $wall;
/*
if(cookie::exists(config::get('general', 'remember/cookie_name')) && !session::exists(config::get('general','session/session_name'))){
	$hash = cookie::get(config::get('general','remember/cookie_name'));
	$hashCheck = db::getInstance()->get(config::get('tables','name/users_session'), array('hash', '=', $hash));
	
	if($hashCheck->get_count()){
		$user = new user($hashCheck->first()->user_id);
		$user->login();
	}
}*/
// USER LANGUAGE
$language = cookie::get(config::get('general','lang/cookie_name'));
$current = isset($language) ? $language : $page->data->language;
lang::setLanguage($current);
?>
