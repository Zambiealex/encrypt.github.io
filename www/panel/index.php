<?php include '../core/init.php'; ?>
<?php 
//global $user;
//if( !$user->isLoggedIn() || $user->isLoggedIn() && !$user->hasPermission("admin") ) { redirect::to('panel'); } 

// GET ACTION
$do = input::get('_a'); 

// START THE PAGE
$page->startUp('admin');
?>