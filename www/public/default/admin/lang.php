<div class="wrapper clearfix">
		<div class="colum colum-s colummarg">
        		<table>
                		<tr>
                        		<th></th>
                        		<th class="simple"><?php page::render($item->name); ?></th> 
                        </tr>
                        <tr>
                        				<td class="title"><?php lang::output('tab_name'); ?></td>
                                		<td data-name="name"> <?php page::render($item->name); ?></td>
                        </tr>
                        <tr>
                        				<td class="title"><?php lang::output('tab_directory'); ?></td>
                                        <td contenteditable="false" data-name="directory"><?php page::render($item->dir); ?></td>
                        </tr>
                        <tr>
                        				<td> OPTIONS </td>
                                        <td><a href="<?php url::action('actions', "lang/delete/$item->name"); ?>"  id="confirm" data-lang="<?php lang::output('text_confirm'); ?>"><?php lang::output('text_delete'); ?></a> </td>
                        </tr>
                </table>
		</div>
        
        <div class="colum colum-m">
        		<table>
                	<tr><th class="simple"><?php lang::output('tab_content'); ?></th></tr>
                	<tr>
                    <td class="hidden" contenteditable="false" data-name="url"><?php url::action('actions', "lang/update/$item->name"); ?></td>
                    <td class="hidden" contenteditable="false" data-name="token"><?php page::render(token::generate('langs')); ?></td>
                    <td contenteditable="true" data-name="lang">
						<?php 
									$text = '';
                                    $f = fopen($item->dir, 'r+');
                                    while(!feof($f))
                                    {
                                            $text .= fgets($f). '<br>';
                                    }
                                    fclose($f);
									echo trim($text);
                        ?>
                    </td>
                    </tr>
                </table>
        </div>
</div>