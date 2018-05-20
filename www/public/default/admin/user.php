<div class="wrapper">
		<div class="colum colum-f">
        	 <table>
             		<tr>	
                    		<th></th>
                            <th style="width:50%;text-align:center;" > <?php page::render($item->name); ?> <?php page::render($item->lastname); ?> </th>
                    </tr>
                    <tr>
                    		<td class="title"> <?php lang::output('tab_index'); ?> </td>
                    		<td> <?php page::render($item->id); ?> </td>
                            <td class="hidden" contenteditable="false" data-name="token"><?php page::render(token::generate('update')); ?></td>
                       		 <td class="hidden" contenteditable="false" data-name="url"><?php url::action('access', "update/$item->id"); ?></td>
                    </tr>
                    <tr>
                    		<td class="title"> <?php lang::output('tab_username'); ?> </td>
                    		<td data-name="username" contenteditable="true"> <?php page::render($item->username); ?> </td>
                    </tr>
                    <tr>
                    		<td class="title"> <?php lang::output('tab_name'); ?> </td>
                    		<td data-name="name" contenteditable="true"> <?php page::render($item->name); ?> </td>
                    </tr>
                    <tr>
                    		<td class="title"> <?php lang::output('tab_lastname'); ?> </td>
                    		<td data-name="lastname" contenteditable="true"> <?php page::render($item->lastname); ?> </td>
                    </tr>
                    <tr>
                    		<td class="title"> <?php lang::output('tab_email'); ?> </td>
                    		<td data-name="email" contenteditable="true">  <?php page::render($item->email); ?> </td>
                    </tr> 
                    <tr>
                    		<td class="title"> <?php lang::output('tab_changepass'); ?> </td>
                            <td data-name="password" contenteditable="true"></td>
                            <td style="width:50%" data-name="password_again" contenteditable="true"></td>
                    </tr> 
                    <tr>
                    		<td class="title"> <?php lang::output('tab_group'); ?> </td>
                    		<td data-name="group" contenteditable="true"> <?php page::render($item->group); ?> </td>
                            <td> <?php page::render($user->getGroup($item->group)->name); ?> </td>
                    </tr>
                    <tr>
                    		<td class="title"> <?php lang::output('tab_joined'); ?> </td>
                    		<td> <?php page::render($item->joined); ?> </td>
                    </tr>
                    <tr>
                    		<td class="title"> <?php lang::output('tab_options'); ?></td>
                            <td>   <a href="<?php url::action('access', "delete/$item->id"); ?>" id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a></td>
                    </tr>
             </table>
        </div>
</div>