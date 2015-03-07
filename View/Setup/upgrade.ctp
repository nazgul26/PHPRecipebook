<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Start'), array('action' => 'index')); ?></li>
    <li class="active"><?php echo __('Upgrade');?></li>
</ol>
<ul>
<spacer/>
<span class="cake-debug">
    <?php echo __('Upgrading will lock all users and require they change their passwords.  This was needed to use Blowfish encryption.');?>
</span>
<br/><br/>
<p>
    <?php echo __('Follow the following steps to upgrade your installation:');?>
</p>   

<ul>
    <li><?php echo __('Make a backup of your database!');?></li>
    <li><?php echo __('Migrate from latest 4.x PHPRecipeBook to 5.0');?> -<br/>
        <b>./Config/SQL/upgrade/recipedb-4.x-5.0.sql</b>
    </li>
    <li>
        Edit the configuration file to set your Email Server/Account<br/>
        <b>./Config/email.php</b>
    </li> 
</ul>
<br/>

<?php echo $this->Html->link(__('Continue'), array( 'action' => 'password'), array('class' => 'btn-primary')); ?>