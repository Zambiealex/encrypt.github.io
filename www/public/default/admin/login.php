<div class="wrapper">
			<div class="col colum-m">
            		<div class="form-group">
                    		<form action="<?php url::action('access', 'login'); ?>" method="post">
                            		<h4> <?php lang::output('text_adminpanel'); ?> </h4>
                            		<div class="form-control">
                                    	<input type="text" name="username" placeholder=" <?php lang::output('placeholder_username'); ?>">
                                    </div>
                                    <div class="form-control">
                                    	<input type="password" name="password" placeholder=" <?php lang::output('placeholder_password'); ?>">
                                    </div>
                                    <div class="form-control">
                                    	<input type="submit" value="<?php lang::output('form_login'); ?>">
                                    </div>
                                    <input type="hidden" name="token" value="<?php page::render(token::generate('login')); ?>" />
                            </form>
                    </div>
            </div>
			
</div>