<?php include '../core/init.php'; ?>
<?php
global $do, 
	   $template,
	   $page,
	   $user,
	   $category,
	   $wall,
	   $section,
	   $advertising,
	   $secure;

if( input::exists('get') )
{
		$auth = input::get('_n'); // GET ACTION
}
else 
{
		exit; // DO NOTHING	
}

$validation = new validation();

$query = $page->route($auth);
 
$errors = array();

if( DEBUG != 0)
{
	debug($query);
	debug($_POST);
	debug($_SESSION);
	debug($_FILES);
}

switch($query->action)
{
		case 'get':
					switch ($query->root)
					{
								case 'recent':
											$r = $category->query(array(
															'action' => 'SELECT *',
															'where' =>  array('ignore' , '=', 0),
															'limit' =>  '',
															'order' => 'ORDER BY RAND()'
												))->results();
											$find = $r[rand(0,strlen($r))];
											$p = $wall->query(
													array(
														'action' => 'SELECT *',
														'where' => array('categoryid', '=', $find->id),
														'limit' => 'LIMIT 1',
														'order' => 'ORDER BY `id` DESC'
													))->results();
													
											$ar = array();
											foreach($p as $key => $item)
											{
													$item->source = url::path('gallery', $item->folderid, $item->content, 1);
													
													$path = url::path('gallery', $item->folderid, '', 1);
													$item->sourceimage = thumb::generate(url::path('gallery', $item->folderid, $item->thumb, 1), $item->thumb, "class='expand' data-original='{$item->content}' data-thumb='{$item->thumb}' data-folder='{$path}'");
													$item->filename = page::break_message($item->content,  10, -10);
													$item->link = url::generate( $find->link . DS . 'thread' . DS . $item->id);
													$item->lang_comment = lang::output('link_comment', 1);
													$item->message = page::break_message($item->message, 500, 0, ' ...');
													$count = $page->counting('comments', 'postid', $item->id);
													$item->comments = $count .  lang::output('text_comment', 1);
													$item->author = (empty($item->author) != false ) ? lang::output('text_name',1) : $item->author;
													$ar[] = $item;
											}
											echo json_encode($ar);
											return;
									break;
					}
			break;
		case 'create':
					switch ($query->root)
					{
								case 'lang':
										if(token::check("lang", input::get('token')))
										{
												$name = input::get('name');
												$directory = lang::langdir($name);
												
												if(!file_exists($directory))
												{
															$f = fopen($directory, 'w');
															$text =	$template->view('other/empty', 1);
															fwrite($f, $text, strlen($text));
															fclose($f);
												}
										}
									break;
								case 'category':
										if(token::check('admin', input::get('token')))
										{
											$validation->check($_POST,array(
																'name' => array( 'required' => true),
																'link' => array( 'required' => true),
																'extension' => array( 'required' => true),
											));
													
											if( $validation->passed() )
											{		
												$ignore = (input::get('ignore') != 'on') ? 0 : 1;
												
												$category->create( array(
														'name' => input::get('name'),
														'link' => input::get('link'),
														'extsupport' =>  input::get('extension'),
														'ignore' => $ignore
												));
											}
											else
											{
													foreach($validation->errors() as $error) 
													{
															$errors[] = $error;
													}	
											}
										}
									break;
								case 'advert':
										if(token::check('admin', input::get('token')))
										{
											$validation->check($_POST,array(
																'title' => array( 'required' => true),
																'type' => array( 'required' => true),
																'code' => array( 'required' => true),
											));
											
											if( $validation->passed() )
											{
													$advertising->create(array(
															'title' => input::get('title'),
															'type' => input::get('type'),
															'code' => input::get('code')
										
													));
											}
											else
											{
													foreach($validation->errors() as $error) 
													{
															$errors[] = $error;
													}	
											}
										}
									break;
								case 'post':
										if(input::exists())
										{
												if(token::check("post", input::get('token')))
												{
															$validation->check($_POST,array(
																	'message' => array( 'required' => true),
															));
															
															// IMG UPLOAD
															$path = md5(uniqid() . rand(1, 999));
															$data = $validation->uploadImage($path, array('content'));
															
															if( !isset($data->content) ){
																	$validation->addError('content is required');
															}
															
															if( $validation->passed() )
															{
																		$name = escape(input::get('name'));
																		$index = $wall->create('posts',array(
																					'author' => trim($name),
																					'auth_addr' => $secure->auth_addr,//input::get('auth_addr'),
																					'title' => input::get('title'),
																					'message' => input::get('message'),
																					'categoryid' => $secure->category,//input::get('categoryid'),
																					'content' => $data->content,
																					'folderid' => $path,
																					'create_date' =>  date("c", time()) ,
																					'thumb' => $data->thumb
																		) );
																		
															}
															else
															{
																	foreach($validation->errors() as $error) 
																	{
																			$errors[] = $error;
																	}	
															}
												}
										}
									break;
								case 'comment':
										if(input::exists())
										{
												if(token::check("comment", input::get('token')))
												{
															$validation->check($_POST,array(
																	'message' => array( 'required' => true),
															));
															
															// IMG UPLOAD
															$path = input::get('folderid');
															$data = $validation->uploadImage($path, array('content'));
															
															$source = isset($data->content) ? $data->content : '';
															$thumbnail = isset($data->thumb) ? $data->thumb : '';
															if( $validation->passed() )
															{
																		$name = escape(input::get('name')); 
																		$index = $wall->create('comments', array(
																					'author' => trim($name),
																					'auth_addr' => $secure->auth_addr,
																					'title' => input::get('title'),
																					'message' => input::get('message'),
																					'postid' => $secure->postid,
																					'content' => $source ,
																					'folderid' => $path,
																					'create_date' =>  date("c", time()) ,
																					'thumb' => $thumbnail
																		));
																		
															}
															else
															{
																	foreach($validation->errors() as $error) 
																	{
																			$errors[] = $error;
																	}	
															}
												}
										}
									break;
								case 'report':
										if(input::exists())
										{
												if(token::check("report", input::get('token')))
												{
															$com = input::get('comid');
															$po = input::get('postid');
															
															$validation->check($_POST,array(
																	'message' => array( 'required' => true),
															));
															
															
															if( $validation->passed() )
															{
																		$reports->create(
																		array(
																				'message' => escape(input::get('message')),
																				'postid' => $po,
																				'comid' => $com,
																				'author_addr' => $secure->auth_addr
																		));
															}
															else
															{
																	foreach($validation->errors() as $error) 
																	{
																			$errors[] = $error;
																	}	
															}
												}
												
										}
									break;
						
					}
			break; // CREATE
		case 'update':
		case 'edit':
					switch ($query->root)
					{
								case 'category' : 
								{
									if(input::exists())
									{
										if(token::check('update', input::get('token')))
										{
											$validation->check($_POST,array(
																'name' => array( 'required' => true),
																'link' => array( 'required' => true),
																'extension' => array( 'required' => true),
											));
											
											if( $validation->passed() )
											{
												$ignore =  (!is_numeric(input::get('ignore'))) ? 0 : input::get('ignore');
												
												if( $ignore > 1 || $ignore < 0 )
															$ignore = 1;
															
												$category->update( array(
														'name' => input::get('name'),
														'link' => input::get('link'),
														'extsupport' =>  input::get('extension'),
														'ignore' => $ignore
												), $query->index);
											}
											else
											{
													foreach($validation->errors() as $error) 
													{
														$errors[] = $error;
													}	
											}
										}
									}
								}
								case 'page':
								{
										if(input::exists())
										{
											if(token::check('update', input::get('token')))
											{
													$page->update(
														array(
															'title' => input::get('title'),
															'subtitle' => input::get('subtitle'),
															'description' => input::get('description'),
															'tags' => input::get('tags'),
															'theme' => trim(input::get('theme')),
															'language' => trim(input::get('language')),
															'logo' => trim(input::get('logo')),
															'favicon' => trim(input::get('favicon')),
															'ffmpeg' => trim(input::get('ffmpeg'))
															
														)
													,$page->data->id);
											}
										}
								}
								case 'advert':
								{
									if(input::exists())
									{
										if(token::check('update', input::get('token')))
										{
												$validation->check($_POST,array(
																'title' => array( 'required' => true),
																'code' => array( 'required' => true),
																'type' => array( 'required' => true),
												));
												
												if( $validation->passed() )
												{
													$advertising->update(array(
														'title' => input::get('title'),
														'code' => input::get('code'),
														'type' => input::get('type')
													), $query->index);
												}
												else
												{
														foreach($validation->errors() as $error) 
														{
															$errors[] = $error;
														}	
												}
												
										}
									}
												
								}
								case 'post':
										if(input::exists())
										{
													if(token::check("update", input::get('token')))
													{
															$validation->check($_POST,array(
																	'message' => array( 'required' => true),
															));
															
															if( $validation->passed() )
															{
																		$name = escape(input::get('name'));
																		$wall->update('posts',array(
																					'author' => trim($name),
																					'auth_addr' => input::get('auth_addr'),
																					'title' => input::get('title'),
																					'message' => input::get('message'), 
																					'content' => input::get('content'),
																					'folderid' => input::get('folderid'), 
																					'thumb' => input::get('thumb')
																		) , $query->index);
																		
															}
															else
															{
																	foreach($validation->errors() as $error) 
																	{
																		$errors[] = $error;
																	}	
															}
													}
										}
									break;
								case 'comment':
										if(input::exists())
										{
													if(token::check("update", input::get('token')))
													{
															$validation->check($_POST,array(
																	'message' => array( 'required' => true),
															));
															
															if( $validation->passed() )
															{
																		$name = input::get('name');
																		$wall->update('comments',array(
																					'author' => escape(trim($name)),
																					'auth_addr' => input::get('auth_addr'),
																					'title' => input::get('title'),
																					'message' => input::get('message'),
																					'content' => input::get('content'),
																					'folderid' => input::get('folderid'), 
																					'thumb' => input::get('thumb')
																		) , $query->index);
																		
															}
															else
															{
																	foreach($validation->errors() as $error) 
																	{
																		$errors[] = $error;
																	}	
															}
													}
										}
									break;
								case 'lang':
										if(input::exists())
										{
													if(token::check("langs", input::get('token')))
													{
															$directory = input::get('directory');
															$name = trim(input::get('name'));
															$text = input::get('lang'); 
															
															if($fh = fopen($directory,'w+'))
															{ 
																fwrite($fh, trim($text), strlen($text));
																fclose($fh);
															}
															
													}
										}
									break;
						
					}
			break; // EDIT OR UPDATE
		case 'remove':
		case 'delete':
					switch ($query->root)
					{
								case 'category' : 
								{
										if(!$category->find($query->index) )
													return;
													
										$category->delete($query->index);
										$q = $wall->query(array(
												'action' => 'SELECT `id`, `folderid`',
												'where' => array('categoryid', '=', $query->index),
												'order' => '',
												'limit' => ''	
											))->results();
										if(!empty($q))
										{	
												foreach($q as $item)
												{
														$wall->delete('comments', $item->id, 'postid');
														
														$patch = url::path('gallery', $item->folderid);
														
														if( is_dir($patch) )
														{
																rmdir($patch);	
														}
												}
										}
										$wall->delete('posts', $query->index, 'categoryid');
									
								}
								case 'report': 
										if(!$reports->find($query->index) )
												return;
												
										$reports->delete($query->index);
									break;
								case 'advert':
								{
										if(!$advertising->find($query->index))
												return;
												
										$advertising->delete($query->index);
								}
								case 'post' :
								{ 
										if(!$wall->find('posts', $query->index, 'id') )
										{
															return;
										}
										$item = $wall->get('posts', $query->index, 'id');
										$patch = url::path('gallery', $item->folderid, $item->content);
										
										if( is_dir($patch) )
										{
												rmdir($patch);	
										}
										
										$wall->delete('posts', $query->index);	
										$wall->delete('comments', $query->index, 'postid');
									
								}
								case 'lang' :
											if(!$lang->find($query->extra->action))
											{
													return;
											}
											
											$lang->delete($query->extra->action);
									break;
						
					}
			break;	
}

if( !empty($errors) )
{
			echo '<div class="error">';
			foreach($errors as $error) 
			{
					echo $error . '<br>';
			}
			echo '</div>';
}	
else if( empty($errors) )
{
		echo '<div class="success">DONE!</div>';
}

?>