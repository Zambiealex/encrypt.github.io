<div class="wrapper">
		<div class="colum colum-f">
        	<table>
            	<form action="<?php url::action('actions', 'advert/create'); ?>" method="post">
            		<tr>
                    		<td><?php lang::output('form_title'); ?> <input type="text" name="title" /> </td>
                            <td><?php lang::output('form_code'); ?> <textarea name="code"></textarea> </td>
                            <td><?php lang::output('form_type'); ?> <input type="text" name="type" /> </td>
                            <td class="hidden"> <input type="hidden" name="token" value="<?php page::render(token::generate('admin'));?>" /> </td>
                            <td> <input type="submit" class="floatright" value="<?php lang::output('form_create'); ?>"  /> </td>
                    </tr>
                </form>
            </table>
        	<table>
            	<tr>
                		<th>#</th>
                		<th><?php lang::output('tab_name'); ?></th>
                        <th><?php lang::output('tab_type'); ?></th>
                        <th><?php lang::output('tab_options'); ?></th>
                </tr>
                <?php foreach($adverts as $item) : ?>
                <tr>
                		<td> <?php page::render($item->id); ?> </td>
                		<td> <?php page::render($item->title); ?> </td>
                        <td> <?php page::render($item->type); ?> </td>
                        <td> <a href="<?php page::render(url::generate("panel/advert/view/$item->id")); ?>"><?php lang::output('text_view'); ?></a> | <a href="<?php url::action('actions', "advert/delete/$item->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a> </td>
                </tr>
                <?php endforeach; ?>
           </table>
        </div>
</div>