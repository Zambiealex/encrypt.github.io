<?php include '../core/init.php'; ?>
<?php
global $do, 
	   $template,
	   $page,
	   $user,
	   $category,
	   $wall,
	   $section,
	   $advertising;

if( input::exists('get') )
{
		$auth = input::get('_n'); // GET ACTION
}
else 
{
		exit; // DO NOTHING	
}

$query = $page->route($auth);

if( DEBUG != 0)
{
	debug($query);
	debug($_POST);
	debug($_SESSION);
}

$errors = array();
$valid = new validation(); 

switch($query->root)
{
		case 'register':
					if( input::exists() )
					{
							if( token::check('register', input::get('token') ) )
							{
								$valid->check($_POST, array(
									'username' => array(
										'required' => true,
										'min' => 3,
										'max' => 32,
										'unique' => config::get('tables', 'name/users') 
									),
									'password' => array(
										'required' => true,
										'min' => 6
									),
									'password_again' => array(
										'required' => true,
										'matches' => 'password'
									),
									'email' => array(
										'required' => true,
										'validate' => true
									)
								));
								
								if($valid->passed())
								{	
									$salt = Hash::salt(32);
									try{
											$user->create(array(
												'username' => escape(input::get('username')),
												'password' => Hash::make(input::get('password'), $salt),
												'email' => input::get('email'),
												'joined' => date("Y-m-d H:i:s"),
												'name' => input::get('name'),
												'lastname' => input::get('lastname'),
												'salt' => $salt,
												'group' => input::get('group')
											));
										 	
									} catch(Execption $e){
											die($e->getMessage());	
									}
									
								}
								else{
										foreach($valid->errors() as $error){
											$errors[] = $error;
										}
								}
							} // TOKEN
					}
			break;
		case 'delete' :
					if($user->find($query->index))
					{
							$user-delete($query->index);	
					}
			break;
		case 'update':
					if( input::exists() )
					{
							if( token::check('update', input::get('token') ) )
							{
								$valid->check($_POST, array(
									'username' => array(
										'required' => true,
										'min' => 3,
										'max' => 32
									),
									'email' => array(
										'required' => true,
										'validate' => true
									)
								));
								
								if( input::get('password') != '' )
								{
									$valid->check($_POST, array(
										'password' => array(
											'required' => true,
											'min' => 6
										),
										'password_again' => array(
											'required' => true,
											'matches' => 'password'
										)
									));
								}
								
								if($valid->passed())
								{	
									$password = NULL;
									$salt = NULL;
									if( input::get('password') != '') 
									{
											$salt = Hash::salt(32);
											$password =  Hash::make(input::get('password'), $salt);
									}
									else {
											$u = $user->process($query->index);
											$password = $u->password;
											$salt = $u->salt;
									}
									
									try{
											$user->update(array(
													'username' => escape(input::get('username')),
													'password' => $password,
													'email' => input::get('email'),
													'name' => input::get('name'),
													'lastname' => input::get('lastname'),
													'salt' => $salt,
													'group' => input::get('group')
											), $query->index);
										 	
									} catch(Execption $e){
											die($e->getMessage());	
									}
									
								}
								else{
										foreach($valid->errors() as $error){
											$errors[] = $error;
										}
								}
							} // TOKEN
					}
			break;
		case 'login': 
				if( input::exists() )
				{
						if(token::check('login', input::get('token') ) )
						{
									$valid->check($_POST, array(
										'username' => array('required' => true),
										'password' => array('required' => true)
								 	));
									
									if($valid->passed())
									{
											$remember = 0;
											$login = $user->login(input::get('username'), input::get('password'), $remember);
											
											if( !$login ) $errors[] = 'failed';
									}
									else
									{
										foreach($valid->errors() as $error){
												$errors[] = $error;
											}
									}
						}
					
				}
			break;
		case 'logout':
			$user->logout();
				redirect::to('init');
			break;	
}

if( !empty($errors) )
{
			echo '<div class="error">';
			foreach($errors as $error) 
			{
					echo   $error ;
			}
			echo '</div>';
}	
else if( empty($errors) )
{
		echo '<div class="success">' . lang::output('text_done', 1) . '</div>';
}


?>