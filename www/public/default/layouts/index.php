
    				<div class="colum colum-l">
                            <div class="row">
                            		<div class="row-title">
                                    	<?php lang::output('text_recent'); ?>
                                    </div>
                                    <div class="row-content" id="routing"> 
                                    		
                                    </div>
                            </div>
                    </div>
                    <div class="colum colum-l">
                    		<div class="row">
                            		<div class="row-title">
                                    	<?php lang::output('text_index'); ?>
                                    </div>
                                    <div class="row-content padside">  
                                    		<div class="section">
                                    					<ul>
                                                        	<?php foreach($category->data() as $source) : ?>
                                                        			<li> <?php page::render('/'.$source->link.'/'); ?> &nbsp; <a href="<?php page::render(url::generate($source->link));?>"><?php page::render(ucfirst($source->name));?></a></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                           			  		</div>	
                                     </div>
                            </div>
                    </div>
                    <div class="clearfix"></div>
                    
<script id="getRecent" type="text/x-jquery-tmpl">

<div class="item">
	<div class="item-image"> 
		<a title="${title}" href="${link}" target="_blank">
				{{html sourceimage}}
		</a>
	</div>
	<div class="item-info">
		<span class="title">${title}</span>
		<strong class="name">${author}</strong>
		<span class="time">
			<abbr class="timeago" title="${create_date}"></abbr>
		</span>
		<span class="comment">
			<span> #${id}</span>
			<a href="${link}">${lang_comment}</a> 
				<span class="comments"> 
					${comments}
				</span>
			<a href="${source}" target="_blank">
				[${filename}]
			</a> 
		</span>
		<p> 
			{{html message}}
		</p>
	</div>
</div>
</script>