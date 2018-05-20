<div class="wrapper">
		 <div class="col colum-f">
        	<table>
            	<tr>
                		<th> # </th>
                		<th><?php lang::output('tab_author'); ?></th>
                        <th><?php lang::output('tab_message'); ?></th>
                        <th><?php lang::output('tab_options'); ?></th>
                </tr>
                <?php foreach($reports as $item) : ?>
                		<tr>
                        		<td> <?php page::render($item->id); ?> </td>
                        		<td> <?php page::render($item->author_addr); ?> </td>
                                <td class="message"> <?php page::render($item->message); ?> </td>
                                <td> 
                                	<a href="<?php page::render(url::generate("panel/report/view/$item->id")); ?>"><?php lang::output('text_view'); ?></a>
                                    |
                                    <a href="<?php url::action('actions', "report/delete/$item->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a>
								
                                </td>
                        </tr>
                <?php endforeach; ?>
           </table>
        </div>
</div>