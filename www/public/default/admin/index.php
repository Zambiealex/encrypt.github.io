<div class="wrapper">
			<div class="colum colum-m">
            		<table>
                    		<tr>
                            		<th></th>
                            		<th class="simple"> <?php lang::output('tab_pagesetting'); ?> </th>
                            </tr>
                            <tr>
                            			
                                        <td class="title"> <?php lang::output('tab_title'); ?> </td>
                            			<td contenteditable="true" data-name="title"><?php page::render($page->data->title); ?></td>
                                        <td class="hidden" contenteditable="false" data-name="token"><?php page::render(token::generate('update')); ?></td>
                       					<td class="hidden" contenteditable="false" data-name="url"><?php url::action('actions', "page/update"); ?></td>
                            </tr>
                            <tr>
                            			
                                        <td class="title"> <?php lang::output('tab_subtitle'); ?></td>
                            			<td contenteditable="true" data-name="subtitle"><?php page::render($page->data->subtitle); ?></td>
                            </tr>
                            <tr>
                            			
                                        <td class="title"> <?php lang::output('tab_description'); ?></td>
                            			<td contenteditable="true" data-name="description"><?php page::render($page->data->description); ?></td>
                            </tr>
                            <tr>
                            			
                                        <td class="title"><?php lang::output('tab_tags'); ?></td>
                            			<td contenteditable="true" data-name="tags" class="message"><?php page::render($page->data->tags); ?></td>
                            </tr>
                            <tr>
                            			
                                        <td class="title"><?php lang::output('tab_theme'); ?></td>
                            			<td contenteditable="true" data-name="theme"><?php page::render($page->data->theme); ?></td>
                            </tr>
                            <tr>
                            			
                                        <td class="title"><?php lang::output('tab_lang'); ?></td>
                            			<td contenteditable="true" data-name="language"><?php page::render($page->data->language); ?></td>
                            </tr>
                            <tr>
                            			
                                        <td class="title"><?php lang::output('tab_logo'); ?></td>
                            			<td contenteditable="true" data-name="logo"><?php page::render($page->data->logo); ?></td>
                            </tr>
                            <tr>
                            			
                                        <td class="title"><?php lang::output('tab_favicon'); ?> </td>
                            			<td contenteditable="true" data-name="favicon"><?php page::render($page->data->favicon); ?></td>
                            </tr>
                            <tr>
                            			<td class="title"><?php lang::output('tab_directory'); ?> FFMPEG </td>
                                        <td contenteditable="true" data-name="ffmpeg"><?php page::render($page->data->ffmpeg); ?></td>
                            
                    </table>
            </div>

	 
</div>