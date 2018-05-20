<?php
 
global $do, 
	   $template,
	   $page,
	   $user,
	   $category,
	   $wall,
	   $advertising,
	   $pagination,
	   $reports,
	   $lang;

// HAS ADMIN PERMISION
if( $user->isLoggedIn() && !$user->hasPermission('admin') ) redirect::to('panel');

// PROCCESS DATA
$query = $page->route($do);
$routing =  $query->root;

// GENERAL STUFF ON TEMPLATES
$template->site = $page->data;

// $HEADER
$template->title = $page->data->title . ' - Panel'; 
$template->view('admin/header');


$paginate = (object) array( 'url' => '', 'page' => '', 'start' => '', 'where' => array() , 'limit' => 0);

// $BODY
switch($routing)
{
		case 'comments':
		case 'comment':
				if( $query->action != '' && $query->action == 'view' &&  $query->index != 0 ) {
						if($wall->find('comments' , $query->index , 'id') ){
								$template->item = $wall->get('comments', $query->index);
								$routing = 'comment';
						}
						else $routing = 'index';
				}
				else $routing = 'index';
			break;
		case 'posts':
		case 'post':
				if( $query->action != '' && $query->action == 'view' &&  $query->index != 0 ) {
					if($wall->find('posts' , $query->index , 'id') ){
						
							$template->item = $wall->get('posts', $query->index);
							$template->comments = $page->counting('comments', 'postid' , $query->index);
							$replace = $category->get($template->item->categoryid);
							$template->go = url::generate( $replace->link . DS . 'thread' . DS . $template->item->id );
							$routing = 'post';
					}
					else $routing = 'posts';
				}
				else
				{
						if( $query->action == 'search')
							if( $wall->find('posts', $query->index, 'id'))
								$paginate->where = array( 'id', '=', $query->index);
								
						if( $query->action == 'page')
								$paginate->page = $query->index;
								
						$pagination->total = $page->counting('posts');
						$paginate->url = url::generate("panel/$routing") . DS . 'page' .DS;
						$paginate->page = ($paginate->page == 0 || $paginate->page == NULL) ? 1 : $paginate->page;
						$paginate->start = ($paginate->page - 1) * $pagination->perPage;
						$paginate->limit = "LIMIT {$paginate->start} , {$pagination->perPage}";
						
						$template->pagination = $pagination->paginate($paginate->url, $paginate->page); 
				 		$template->posts = $wall->query(array(
									'action' => 'SELECT *',
									'where' =>  $paginate->where,
									'limit' =>  $paginate->limit,
									'order' => 'ORDER BY `id` DESC'
						), '')->results();
						$routing = 'posts';
				}
			break;
		case 'reports':
		case 'report':
				if( $query->action != '' && $query->action == 'view' &&  $query->index != 0 ) {
					if($reports->find( $query->index ) ){
							$template->item = $reports->get( $query->index);
						
							$routing = 'report';
					}
					else $routing = 'reports';
				}
				else{
					
						if( $query->action == 'search')
							if( $wall->find('posts', $query->index, 'id'))
								$paginate->where = array( 'id', '=', $query->index);
								
						if( $query->action == 'page')
								$paginate->page = $query->index;
								
						$pagination->total = $page->counting('report');
						$paginate->url = url::generate("panel/$routing") . DS . 'page' .DS;
						$paginate->page = ($paginate->page == 0 || $paginate->page == NULL) ? 1 : $paginate->page;
						$paginate->start = ($paginate->page - 1) * $pagination->perPage;
						$paginate->limit = "LIMIT {$paginate->start} , {$pagination->perPage}";
						
						$template->pagination = $pagination->paginate($paginate->url, $paginate->page); 
				 		$template->reports = $reports->query(array(
									'action' => 'SELECT *',
									'where' =>  $paginate->where,
									'limit' =>  $paginate->limit,
									'order' => 'ORDER BY `id` DESC'
						))->results();
						$routing = 'reports';
				}
			break;
		case 'advert':
		case 'advertising':
				if( $query->action != '' && $query->action == 'view' &&  $query->index != 0 ) {
					if( $advertising->find( $query->index ) ){
							$template->item = $advertising->get($query->index);
							$routing = 'advert';
					}
					else
						$routing = 'advertising';
				}
				else
				{
							if( $query->action == 'page')
									$paginate->page = $query->index;
								
							$pagination->total = $page->counting('adverts');
							$paginate->url = url::generate("panel/$routing") . DS . 'page' .DS;
							$paginate->page = ($paginate->page == 0 || $paginate->page == NULL) ? 1 : $paginate->page;
							$paginate->start = ($paginate->page - 1) * $pagination->perPage;
							$paginate->limit = "LIMIT {$paginate->start} , {$pagination->perPage}";
							
							$template->pagination = $pagination->paginate($paginate->url, $paginate->page); 
							$template->adverts = $advertising->query(array(
										'action' => 'SELECT *',
										'where' =>  ' ',
										'limit' =>  $paginate->limit,
										'order' => 'ORDER BY `id` DESC'
							))->results();
							$routing = 'advertising';
				}
			break;
		case 'category':
		case 'categories':
				if( $query->action != '' && $query->action == 'view' &&  $query->index != 0 ) {
					if( $category->find($query->index , 'id') )
					{
							$template->item = $category->get($query->index);
							$template->go = url::generate($template->item->link);
							$routing = 'category';
					}
					else $routing = 'categories';
				}
				else
			  	{
						if( $query->action == 'page')
								$paginate->page = $query->index;
								
						$pagination->total = $page->counting('category');
						$paginate->url = url::generate("panel/$routing") . DS . 'page' .DS;
						$paginate->page = ($paginate->page == 0 || $paginate->page == NULL) ? 1 : $paginate->page;
						$paginate->start = ($paginate->page - 1) * $pagination->perPage;
						$paginate->limit = "LIMIT {$paginate->start} , {$pagination->perPage}";
						
						$template->pagination = $pagination->paginate($paginate->url, $paginate->page); 
				 		$template->results = $category->query(array(
									'action' => 'SELECT *',
									'where' =>  ' ',
									'limit' =>  $paginate->limit,
									'order' => 'ORDER BY `id` DESC'
						))->results();
						$routing = 'categories';
				}
			break;
		case 'user':
		case 'users':
			if( $query->action != '' && $query->action == 'view' &&  $query->index != 0 ) {
					if( $user->find($query->index) )
					{
								$template->item = $user->process($query->index);
								$routing = 'user';
					}
					else 
								$routing = 'users';
			}
			else
				$routing = 'users';
			break;
		case 'langs':
		case 'lang':
				if( $query->action != '' && $query->action == 'view'){
					if( $lang->find( $query->extra->action ) )
					{
								$template->item = $lang->get($query->extra->action);
								
					}
				}
				else
				{
						$template->results = $lang->get();
				}
			break;
		case 'login':
		default:
				if( !$user->isLoggedIn() ) 
						$routing = 'login';
				else
						$routing = 'index';
			break;
}

// DEBUG
if( DEBUG != 0 ) {
	debug($query);
	debug($routing);
}

if( !$user->isLoggedIn() && $routing != 'login') redirect::to('panel');

$template->view('admin/'. $routing);

// $FOOTER
$template->copyright = $_SERVER['SERVER_NAME'] . ' &copy; ' . date('Y');
$template->view('admin/footer');

?>