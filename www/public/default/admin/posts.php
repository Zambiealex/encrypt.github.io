<div class="wrapper">
		 <div class="col colum-f">
         	<table>
            		<tr>
                    		<td> 
                            	<?php lang::output('form_search'); ?> <input type="search"  id="search" placeHolder=" ID" data-url="<?php page::render(url::generate("panel/posts/search"));?>" />  
                            </td>
                    </tr>
            </table>
        	<table>
            	<tr>
                		<th> # </th>
                		<th> <?php lang::output('tab_author'); ?> </th>
                        <th> <?php lang::output('tab_authaddr'); ?> </th>
                        <th> <?php lang::output('tab_category'); ?> </th>
                        <th> <?php lang::output('tab_content'); ?> </th>
                        <th> <?php lang::output('tab_options'); ?> </th>
                </tr>
                <?php foreach($posts as $item) :?>
                <tr>
                		<td> <?php page::render($item->id); ?></td>
                		<td> <?php (empty($item->author)) ? lang::output('text_name') : page::render($item->author); ?></td>
                        <td> <?php page::render($item->auth_addr); ?> </td>
                        <td> <?php page::render($item->categoryid); ?></td>
                        <td> <?php page::render($item->content); ?></td>
                        <td> <a href="<?php page::render(url::generate("panel/post/view/$item->id")); ?>"> <?php lang::output('text_view'); ?> </a> | <a href="<?php url::action('actions', "post/delete/$item->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a> </td>
                </tr>
                <?php endforeach; ?>
           </table>
           <table>
           		<tr>
                		<th class="simple page"><?php page::render($pagination); ?></th>
                </tr>
           </table>
        </div>
</div>