<div class="wrapper">
		 <div class="col colum-f">
         	<table>
            		<tr> 
                    		<th></th>
                    		<th class="simple"> REPORT #<?php page::render($item->id); ?></th>
                    </tr>
                    <tr>
                    		<td class="title"> <?php lang::output('tab_author'); ?> </td>
                    		<td> <?php page::render($item->author_addr); ?></td>
                    </tr>
                    <tr>
                    		<td class="title" > <?php lang::output('tab_message'); ?> </td>
                    		<td class="message"> <?php page::render($item->message); ?></td>
                    </tr>
                    <tr>
                    		<td class="title" > <?php lang::output('tab_postid'); ?> </td>
                    		<td> <a href="<?php page::render(url::generate("panel/post/view/$item->postid")); ?>"><?php page::render($item->postid); ?></a></td>
                    </tr>
                    <tr>
                    		<td class="title" > <?php lang::output('tab_comid'); ?> </td>
                            <td> <a href="<?php page::render(url::generate("panel/comment/view/$item->comid")); ?>"><?php page::render($item->comid); ?></a></td>
                    </tr>
                    <tr>
                    	<td class="title"><?php lang::output('tab_options'); ?> </td>
                        <td>
                        <a href="<?php url::action('actions', "report/delete/$item->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a>
                        </td>
                    </tr>
           </table>
        </div>
</div>