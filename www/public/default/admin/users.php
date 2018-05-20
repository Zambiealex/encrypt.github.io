<div class="wrapper">
		<div class="colum colum-f">
        	<table>
            	<form action="<?php url::action('access', 'register'); ?>" method="post">
            		<tr>
                    		<td><?php lang::output('form_username'); ?>  <input type="text" name="username" /> </td>
                            <td><?php lang::output('form_email'); ?> <input type="text" name="email" /> </td>
                            <td><?php lang::output('form_name'); ?> <input type="text" name="name" /> </td>
                            <td><?php lang::output('form_lastname'); ?> <input type="text" name="lastname" /> </td>
                    </tr>
                    <tr>
                            <td><?php lang::output('form_password'); ?> <input type="password" name="password" /> </td>
                            <td><?php lang::output('form_retype'); ?> <input type="password" name="password_again" /> </td>
                            <td><?php lang::output('form_group'); ?> <select name="group">
                                    		<?php foreach($user->getGroups() as $group) : ?>
                                            	<option value="<?php page::render($group->id); ?>"><?php page::render($group->name); ?></option>
                                            <?php endforeach; ?> </select>
                            </td>
                            <td class="hidden"> <input type="hidden" name="token" value="<?php page::render(token::generate('register'));?>" /> </td>
                            <td> <input type="submit" class="floatright" value="<?php lang::output('form_create'); ?>"  /> </td>
                    </tr>
                </form>
            </table>
        	<table>
            		<tr>
                    		<th>#</th>
                            <th> <?php lang::output('tab_username'); ?> </th>
                            <th> <?php lang::output('tab_email'); ?> </th>
                            <th> <?php lang::output('tab_name'); ?> </th>
                            <th> <?php lang::output('tab_lastname'); ?> </th>
                            <th> <?php lang::output('tab_options'); ?></th>
                    </tr>
                    <?php 
						  foreach($user->get() as $users):
					?>
                    <tr>
                    		<td> <?php page::render($users->id); ?> </td>
                            <td> <?php page::render($users->username); ?> </td>
                            <td> <?php page::render($users->email); ?> </td>
                            <td> <?php page::render($users->name); ?> </td>
                            <td> <?php page::render($users->lastname); ?> </td>
                            <td>
                            		<a href="<?php page::render(url::generate("panel/user/view/$users->id")); ?>"> <?php lang::output('text_view'); ?></a>
                                    |
                                    <a href="<?php url::action('access', "delete/$users->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a>
                            </td>
                    </tr>
                    <?php endforeach; ?>
           </table>
        </div>
</div>