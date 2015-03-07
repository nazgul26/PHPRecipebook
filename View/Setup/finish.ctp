
<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Setup'), array('action' => 'index')); ?></li>
    <li><?php echo $this->Html->link(__('Database'), array('action' => 'database')); ?></li>
    <li><?php echo $this->Html->link(__('Password'), array('action' => 'password')); ?></li>
    <li class="active"><?php echo __('Finish');?></li>
</ol>
<?php echo $this->Session->flash(); ?>
<spacer/>
<h3>
    <?php echo __('Complete the Setup');?>
</h3>
<p><?php echo __('By editing');?>: ./Config/core.php</p>
<ul>
    <li><?php echo __('Change');?> - Configure::write('App.setupMode', TRUE);</li>
    <li><?php echo __('To');?> - Configure::write('App.setupMode', <b>FALSE</b>);</li>
</ul>
<br/>
<p><b><?php echo __("If you don't change this setting your site will be open for anyone to reconfigure it.");?></b></p>
<br/>
<p><?php echo __('AND if you do not want open registration then change');?>:</p>
<ul>
    <li><?php echo __('Change');?> - Configure::write('App.allowPublicAccountCreation', TRUE);</li>
    <li><?php echo __('To');?> - Configure::write('App.allowPublicAccountCreation', <b>FALSE</b>);</li>
</ul>
<br/>
<p><?php echo __('Congratulations you have successfully setup PHPRecipeBook!');?></p>
<p><?php echo __('Press the done button to login and begin setting up some users or adding recipes.');?></p>
<br/>
<?php echo $this->Html->link(__('Done'), array('controller' => 'users', 'action' => 'index'), array('class' => 'btn-primary')); ?>
    
