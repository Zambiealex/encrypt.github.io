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
                        <td class="hidden" contenteditable="false" data-name="url"><?php url::action('actions', "advert/update/$item->id"); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_title'); ?></td>
                        <td contenteditable="true" data-name="title"><?php page::render($item->title); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_code'); ?></td>
                    	<td contenteditable="true" data-name="code"><?php page::render(escape($item->code)); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_type'); ?></td>
                    	<td class="message" contenteditable="true" data-name="type"><?php page::render($item->type); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_options'); ?></td>
                        <td>
                        		<a href="<?php url::action('actions', "advert/delete/$item->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>" ><?php lang::output('text_delete'); ?></a> 
                        </td>
                        
                </tr>
           </table>
        </div>
</div>