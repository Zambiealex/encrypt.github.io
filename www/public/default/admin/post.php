<div class="wrapper">
		 <div class="col colum-f">
         	
        	<table>
            	<tr>
                		<th></th>
                		<th class="simple"> <?php page::render($item->title); ?> </th>
                       
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_index'); ?></td>
                        <td contenteditable="false" data-name="id"><?php page::render($item->id); ?></td>
                        <td class="hidden" contenteditable="false" data-name="token"><?php page::render(token::generate('update')); ?></td>
                        <td class="hidden" contenteditable="false" data-name="url"><?php url::action('actions', "post/update/$item->id"); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_title'); ?></td>
                        <td class="break" contenteditable="true" data-name="title"><?php page::render($item->title); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_name'); ?></td>
                        <td contenteditable="true" data-name="name"><?php page::render($item->author); ?></td>
                </tr>
                <tr>
                	<td class="title"><?php lang::output('tab_authaddr'); ?></td>
                    <td contenteditable="true" data-name="auth_addr"><?php page::render($item->auth_addr); ?></td>
                 </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_date'); ?></td>
                        <td contenteditable="true" data-name="create_date"><?php page::render($item->create_date); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_message'); ?></td>
                    	<td class="message" contenteditable="true" data-name="message"><?php page::render($item->message); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_media'); ?></td>
                        <td contenteditable="true" data-name="content"><?php page::render($item->content); ?></td>
                        <td>
                        		<a target="_blank" href="<?php page::render(url::generate("gallery/$item->folderid/$item->content")); ?>"> <?php page::render($item->content); ?></a>
                     	</td>
                 </tr>
                <tr>
                        <td class="title"><?php lang::output('tab_thumb'); ?></td>
                        <td contenteditable="true" data-name="thumb"><?php page::render($item->thumb); ?> </td>
                        <td>
                        		<?php page::render(thumb::generate( url::path('gallery', $item->folderid, $item->thumb, 1) ,$item->thumb, '',120 , 90)); ?>
                     	</td>
                </tr>
                <tr>
                        <td class="title"><?php lang::output('tab_folderid'); ?></td>
                        <td contenteditable="true" data-name="folderid"><?php page::render($item->folderid); ?></td>
                        <td>
                        		<a target="_blank" href="<?php page::render(url::generate("gallery/$item->folderid")); ?>"> <?php page::render($item->folderid); ?></a>
                     	</td>
                </tr> 
                <tr>
                        <td class="title"><?php lang::output('tab_comments'); ?></td>
                        <td>
                       			 <?php page::render($comments); ?>
                        </td>
                       
                </tr> 
                <tr>
                		<td class="title"><?php lang::output('tab_options'); ?></td>
                        <td>
                        		<a href="<?php url::action('actions', "post/delete/$item->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a> 
                                | 
                                <a href="<?php page::render($go); ?>" target="_blank"><?php lang::output('text_goto'); ?></a>
                       </td>
                        
                </tr>
           </table>
        </div>
</div>