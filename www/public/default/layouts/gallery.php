
<div class="colum colum-l">
            		<div class="row">
                    		<div class="row-title"> <?php lang::output('form_newth'); ?> </div>
                            <div class="row-content">
           						<div class="form-group">
                                        <form class="half" id="post"action="<?php url::action('actions', 'post/create'); ?>"  method="post" enctype="multipart/form-data">
                                            <div class="form-control">
                                                <input type="text" name="name" placeholder=" <?php lang::output('placeholder_name'); ?>"/>
                                            </div>
                                            <div class="form-control">
                                                <input type="text" name="title" placeholder=" <?php lang::output('placeholder_title'); ?>"/>
                                            </div>
                                            <div class="form-control">
                                              <textarea name="message" placeholder=" <?php lang::output('placeholder_message'); ?>"></textarea>
                                            </div>
                                            <div class="form-control">
                                            	<label><?php lang::output('text_filesallow')?>&nbsp;<?php page::render($accept); ?></label>
                                                <input name="content" type="file"  accept="<?php page::render($accept); ?>"/>
                                            </div>
                                            <div class="form-hidden">
                                                <input type="hidden" readonly="readonly" name="token" value="<?php page::render(token::generate("post")); ?>" />
                                            </div>
                                            <div class="form-control">
                                                <input type="submit" value="<?php lang::output('form_post'); ?>" />
                                            </div>
                                        </form>
                    			</div>
                  			</div>
                    </div>
</div>
<div class="colum colum-l">
              			 
                         <div class="advertising"><?php $advertising->random('center');?></div>
                         <ul class="gallery">
                            		<?php foreach($posts as $item) : ?> 
                                    		<li class="clearfix">
                                            		<div class="item">
                                                 
                                                    		<div class="item-image"> 
                                                            	<a title="<?php page::render($item->title); ?>" href="<?php url::path('gallery', $item->folderid, $item->content); ?>" target="_blank">
                                                            		<?php
																		$path = url::path('gallery', $item->folderid, '', 1);
																		page::render(thumb::generate(url::path('gallery', $item->folderid, $item->thumb, 1), $item->thumb, "data-original='{$item->content}' data-thumb='{$item->thumb}' data-folder='{$path}'")); ?>
                                                                </a>
                                                            </div>
                                                            <div class="item-info">
                                                            		<span class="title"> <?php page::render($item->title); ?></span>
                                                            		<strong class="name">
																			<?php (empty($item->author) != false) ? lang::output('text_name') : page::render($item->author); ?>
                                                                    </strong>
                                                                    <span class="time">
                                                                    		<abbr class="timeago" title="<?php page::render($item->create_date); ?>"></abbr>
                                                                    </span>
                                                                    <span class="comment">
                                                                    	
                                                                         <span>
                                                                         		#<?php page::render($item->id); ?>
                                                                         </span>
                                                                        <a href="<?php page::render($categorylink . $item->id); ?>"><?php lang::output('link_comment'); ?></a> 
                                                                        <span class="comments"> 
																		<?php $count = $page->counting('comments', 'postid', $item->id);
																					page::render($count); 
																					lang::output('text_comment')
																		?>  
                                                                        </span>
                                                                        <a href="<?php url::path('gallery', $item->folderid, $item->content); ?>" target="_blank">
                                                             	                                                   [<?php page::render(page::break_message($item->content,  10, -10)); ?>]
                                     									 </a> 
                                                                    </span>
                                                                    <span class="floatright">
                                                                    	<a id="report" class="clearfix" title=<?php lang::output('text_report'); ?> data-index="<?php page::render($item->id); ?>" data-report="post" data-lang="<?php lang::output('text_thread'); ?>">
                                                                        		 <span class="icon warning"></span>
                                                                        </a>
                                                                    </span>
                                                                    <p> 
                                                                    		<?php page::render( page::break_message($item->message, 500, 0, ' ...')); ?>
                                                                    </p>
                                                            </div>
                                                    </div>
                                            </li>
                                    <?php  endforeach; ?>  
               			 </ul>
                         <div class="page">
                         		<?php page::render($pagination); ?>
                         </div>
</div>
<div class="clearfix" id="clearfix"></div>
<table class="tab-fix hidden tab-collapse" >
		<form action="<?php url::action('actions', 'report/create'); ?>" method="post">
        		<tr>
                		<th class="simple">
								<?php lang::output('tab_report'); ?>
                     			<a href="#" class="close floatright">
                                	X
                                </a>
                        </th>
                        
                </tr>
                <tr>
                		<td class="index"></td>
                </tr>
                <tr>
                		<td> 
                       		<textarea class="message" name="message" placeholder="<?php lang::output('placeholder_report'); ?>"></textarea>
                        	<input type="hidden" value="<?php page::render(token::generate('report')); ?>" name="token" /> 
                            <input type="hidden" value="" name="postid" />
                            <input type="hidden" value="" name="comid" />  
                        </td>
                </tr>
                <tr>
                		<td> <input type="submit" class="floatright" value="<?php lang::output('form_report'); ?>" /> </td>
                </tr>
        </form>
</table>