<?php
// VARS		
global $do, 
	   $template,
	   $page,
	   $user,
	   $category,
	   $pagination,
	   $advertising,
	   $wall,
	   $secure;

// PROCCESS DATA
$query = $page->route($do);
$routing =  $query->root;

// GENERAL STUFF ON TEMPLATES
$template->site = $page->data;

// $HEADER
$subtitle = ($page->data->subtitle != '') ? ' - ' . $page->data->subtitle : '';
$template->title = $page->data->title . $subtitle ; 
$template->copyright = $_SERVER['SERVER_NAME'] . ' &copy; ' . date('Y');

// DEBUG
if( DEBUG ==1 )
	debug($query);

$paginate = (object) array( 'url' => '', 'page' => '', 'start' => '');

// SECURE 
$secure->auth_addr = $user->get_ip();

// $BODY
switch($routing)
{
		case 'panel':
		case 'cp':
			return;
			break;
		default:  
			if( $category->find($routing, 'link') )
			{
					// VARS
					$index = NULL;
					
					// TMPL VARS
					$source = $category->get($routing, 'link');
					$template->categorylink = url::generate( $source->link . DS . 'thread' . DS);
					$template->accept = $source->extsupport;
					
					// SECURE INFO
					$secure->category = $source->id;
					
					if( $query->action != '' && $query->action == 'thread' && $query->index != 0)
					{
							if($wall->find('posts', $query->index, 'id') )
									$index =  $query->index;
					}
					
					if( $index != 0) 
					{
						$secure->postid = $index;
						$template->item = $wall->get('posts', $index);
						$template->comments = $wall->query(array(
							'action' => 'SELECT *',
							'where' => array('postid' , '=', $index),
							'limit' => 'LIMIT 0, 10',
							'order' => 'ORDER BY `id` ASC'
						), 'th_comments')->results();
						$routing = 'item';
					}
					else 
					{
						if( $query->action == 'page')
								$paginate->page = $query->index;
						$pagination->total = $page->counting('posts', 'categoryid' , $source->id, NULL);
						$paginate->url = url::generate($source->link) . DS . 'page' .DS;
						$paginate->page = ($paginate->page == 0 || $paginate->page == NULL) ? 1 : $paginate->page;
						$paginate->start = ($paginate->page - 1) * $pagination->perPage;
						$l = "LIMIT {$paginate->start} , {$pagination->perPage}";
						
						$template->pagination = $pagination->paginate($paginate->url, $paginate->page);
			
						$template->posts = $wall->query(array(
							'action' => 'SELECT *',
							'where' => array('categoryid' , '=', $source->id),
							'limit' => $l,
							'order' => 'ORDER BY `id` DESC'
						), '')->results();
						$routing = 'gallery';
					}
			}
			else $routing = 'index';
			break;
}
$template->view('layouts/header');
$template->view('layouts/'. $routing);

// $FOOTER
$template->view('layouts/footer');

?>