<div class="wrapper">
		<div class="colum colum-f">
        	<table>
            	<form action="<?php url::action('actions', 'category/create'); ?>" method="post">
            		<tr>
                    		<td> <?php lang::output('form_name'); ?> <input type="text" name="name" /> </td>
                            <td> <?php lang::output('form_link'); ?> <input type="text" name="link" /> </td>
                            <td> <?php lang::output('form_extension'); ?> <input type="text" name="extension" /> </td>
                            <td> <?php lang::output('form_ignore'); ?> <input type="checkbox" name="ignore" /> </td>
                            <td class="hidden"> <input type="hidden" name="token" value="<?php page::render(token::generate('admin'));?>" /> </td>
                            <td> <input type="submit" class="floatright" value="<?php lang::output('form_create'); ?>"  /> </td>
                    </tr>
                </form>
            </table>
        	<table>
            	<tr>
                		<th> # </th>
                		<th> <?php lang::output('tab_name'); ?> </th>
                        <th> <?php lang::output('tab_link'); ?> </th>
                        <th> <?php lang::output('tab_extensions'); ?> </th>
                        <th> <?php lang::output('tab_options'); ?> </th>
                </tr>
                <?php foreach($results as $item) : ?>
                <tr>
                		<td> <?php page::render($item->id); ?> </td>
                		<td> <?php page::render($item->name); ?> </td>
                        <td> <a  target="_blank" href="<?php page::render(url::generate($item->link)); ?>"><?php page::render($item->link); ?></a></td>
                        <td> <?php page::render($item->extsupport); ?></td>
                        <td> <a href="<?php page::render(url::generate("panel/category/view/$item->id")); ?>"><?php lang::output('text_view'); ?></a> | <a href="<?php url::action('actions', "category/delete/$item->id"); ?>"  id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a> </td>
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