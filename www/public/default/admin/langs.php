<div class="wrapper clearfix">
		<div class="colum colum-f">
        		<table>	
                	<form action="<?php url::action('actions', 'lang/create'); ?>" method="post">
                    		<tr>
                            		<td><?php lang::output('form_name'); ?><input type="text" name="name"  /></td>
                                    <td>
                                    		<input type="hidden" name="token" value="<?php page::render(token::generate('lang')); ?>" />
                                    		<input type="submit" class="floatright" value="<?php lang::output('form_create'); ?>" />
                                    </td>
                            </tr>
                    </form>
                </table>
        		<table>
                		<tr>
                        		<th><?php lang::output('tab_name'); ?></th>
                                <th><?php lang::output('tab_directory'); ?></th>
                                <th><?php lang::output('tab_options'); ?></th>
                        </tr>
                        <?php foreach($results as $item) : ?>
                        		<tr>
                                		<td><?php page::render($item->name); ?></td>
                                        <td><?php page::render($item->dir); ?></td>
                                        <td> <a href="<?php page::render(url::generate("panel/lang/view/$item->name")); ?>"> <?php lang::output('text_view'); ?> </a> | <a href="<?php url::action('actions', "lang/delete/$item->name"); ?>"  id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a> </td>
                                </tr>
                        <?php endforeach; ?>
                </table>
		</div>
</div>