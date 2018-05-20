<div class="wrapper">
		 <div class="col colum-f">
         	
        	<table>
            	<tr>
                		<th></th>
                		<th class="simple"> <?php page::render($item->name); ?> </th>
                       
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_index'); ?></td>
                        <td contenteditable="false" data-name="id"><?php page::render($item->id); ?></td>
                        <td class="hidden" contenteditable="false" data-name="token"><?php page::render(token::generate('update')); ?></td>
                        <td class="hidden" contenteditable="false" data-name="url"><?php url::action('actions', "category/update/$item->id"); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_name'); ?></td>
                        <td contenteditable="true" data-name="name"><?php page::render($item->name); ?></td>
                </tr>
                <tr>
                	<td class="title"><?php lang::output('tab_link'); ?></td>
                    <td contenteditable="true" data-name="link"><?php page::render($item->link); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_extensions'); ?></td>
                    	<td class="message" contenteditable="true" data-name="extension"><?php page::render($item->extsupport); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_ignore'); ?></td>
                    	<td class="message" contenteditable="true" data-name="ignore"><?php page::render($item->ignore); ?></td>
                </tr>
                <tr>
                		<td class="title"><?php lang::output('tab_options'); ?></td>
                        <td>
                        		<a href="<?php url::action('actions', "category/delete/$item->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a> 
                                | 
                                <a href="<?php page::render($go); ?>" target="_blank"> <?php lang::output('text_goto'); ?> </a>
                                </td>
                        
                </tr>
           </table>
        </div>
</div>