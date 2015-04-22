<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__d('setup','Start'), array('action' => 'index')); ?></li>
    <li class="active"><?php echo __d('setup','Upgrade');?></li>
</ol>
<ul>
<spacer/>
<span class="cake-debug">
    <?php echo __d('setup','Upgrading will lock all users and require they change their passwords.  This was needed to use Blowfish encryption.');?>
</span>
<br/><br/>
<p>
    <?php echo __d('setup','Follow the following steps to upgrade your installation:');?>
</p>   

<ul>
    <li><?php echo __d('setup','Make a backup of your database!');?></li>
    <li><?php echo __d('setup','Migrate from latest 4.x PHPRecipeBook to 5.0');?> -<br/>
        <b>./Config/SQL/upgrade/recipedb-4.x-5.0.sql</b>
    </li>
    <li>
        Edit the configuration file to set your Email Server/Account<br/>
        <b>./Config/email.php</b>
    </li> 
</ul>
<br/>

<?php echo $this->Html->link(__('Continue'), array( 'action' => 'password'), array('class' => 'btn-primary')); ?>