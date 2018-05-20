 <div class="colum colum-l">
            		<div class="row">
                    	<div class="row-title"> <?php lang::output('form_newcom'); ?> </div>
                        <div class="row-content">
							<div class="form-group">
        			<form class="half" action="<?php url::action('actions', 'comment/create'); ?>"  method="post" enctype="multipart/form-data">
        			<div class="form-control">
                    	<input name="name" type="text" placeholder=" <?php lang::output('placeholder_name'); ?>"/>
                    </div>
                    <div class="form-control">
                    	<input name="title" type="text" placeholder=" <?php lang::output('placeholder_title'); ?>"/>
                    </div>
                    <div class="form-control">
                      <textarea name="message" id="placeIndex" placeholder=" <?php lang::output('placeholder_message'); ?>"></textarea>
                    </div>
                    <div class="form-control">
                    	<label><?php lang::output('text_filesallow')?>&nbsp;<?php page::render($accept); ?></label>
                    	<input name="content" type="file" accept="<?php page::render($accept); ?>" />
                    </div>
                    <div class="form-hidden">
                        <input type="hidden" readonly="readonly" name="token" value="<?php page::render(token::generate("comment")); ?>" />
                     
                        <input type="hidden" readonly="readonly" name="folderid" value="<?php page::render($item->folderid); ?>" />
                    </div>
                    <div class="form-control">
                    	<input type="submit" value="<?php lang::output('form_comment'); ?>" />
                    </div>
        		</form>
			</div>
            		 	</div>
                    </div>
</div>
<div class="colum colum-l">
					<div class="advertising"><?php $advertising->random('center');?></div>
					<div class="item padtopdown" id="<?php page::render($item->id); ?>">
                                <div class="item-image">
                                <a href="<?php url::path('gallery', $item->folderid, $item->content); ?>" target="_blank">
                                                            		<?php
																		$path = url::path('gallery', $item->folderid, '', 1);
																		page::render(thumb::generate(url::path('gallery', $item->folderid, $item->thumb, 1), $item->thumb, "class='expand' data-original='{$item->content}' data-thumb='{$item->thumb}' data-folder='{$path}'")); ?>
                                </a>
                                </div>
                                <div class="item-info">
                                		<span class="title"> <?php page::render($item->title); ?></span>
                                        <strong class="name"> <?php (empty($item->author) != false) ? lang::output('text_name') : page::render($item->author); ?> </strong> 
                                        <span class="time">           		<abbr class="timeago" title="<?php page::render($item->create_date); ?>"></abbr> </span> 
                                        <span class="index">
                                        #<?php page::render($item->id); ?>
                                        <a href="<?php url::path('gallery', $item->folderid, $item->content); ?>" target="_blank">
                                                             	                                                   [<?php page::render(page::break_message($item->content,  10, -10)); ?>]
                                        </a> 
                                        </span>
                                        <span class="floatright">
                                                                    	<a id="report" class="clearfix" data-lang="<?php lang::output('text_thread'); ?>" title=<?php lang::output('text_report'); ?> data-index="<?php page::render($item->id); ?>" data-report="post">
                                                                        		 <span class="icon warning"></span>
                                                                        </a>
                                        </span>
                                        <p>
                                                <?php page::render($item->message); ?>
                                        </p>
                                </div>
           		 </div>
            <div class="item-gallery"> 
            		<ul>
                    	<?php foreach($comments as $comment) : ?>
                    	<li>
            							<div class="item-reply" id="comment_<?php page::render($comment->id); ?>">
                                               	<div class="info">
                                                	 <span class="title"> <?php page::render($comment->title); ?></span>
                                                	 <strong class="name"> <?php (empty($comment->author)) ? lang::output('text_name') : page::render($comment->author); ?> </strong>  
                                                     <span class="time">           		<abbr class="timeago" title="<?php page::render($comment->create_date); ?>"></abbr></span>
                                                    
                                                     <span class="index">
                                                     	<span class="index-num">
                                                     		 <a class="index-attr" id="#<?php page::render($comment->id); ?> "> #<?php page::render($comment->id); ?>  </a>
                                                        </span>
                                                      <?php if( !empty($comment->content) ) :?>
                                                      <a href="<?php url::path('gallery', $comment->folderid, $comment->content); ?>" target="_blank">
                                                      [<?php page::render(page::break_message($comment->content,  10, -10)); ?>]
                                        			  </a> 
                                                     
                                                     <?php endif; ?>
                                                     </span>
                                                    <span class="floatright">
                                                                    	<a id="report" class="clearfix" title=<?php lang::output('text_report'); ?> data-index="<?php page::render($comment->id); ?>" data-report="comment" data-lang="<?php lang::output('text_comments'); ?>">
                                                                        		 <span class="icon warning"></span>
                                                                        </a>
                                      			  </span>
                                                </div>
                                                <?php if( !empty($comment->content) ) :?>
                                                <div class="item-reply-img">
                                                	 <a href="<?php url::path('gallery', $comment->folderid, $comment->content); ?>" target="_blank">
                                                            		<?php
																		$path = url::path('gallery', $comment->folderid, '', 1);
																		page::render(thumb::generate(url::path('gallery', $comment->folderid, $comment->thumb, 1), $comment->thumb, " class='expand' data-original='{$comment->content}' data-thumb='{$comment->thumb}' data-folder='{$path}'")); ?>
                                					</a>
                                                </div>
                                                <?php endif; ?>
                                                <p class="message" id="comment">
                                                 	 <?php page::render($comment->message); ?>
                                                </p>    
                                        </div> 
           							    <div class="clearfix"></div>
                     </li>
                     <?php endforeach; ?>
                  </ul>
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