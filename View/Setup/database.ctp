<ol class="breadcrumb">
    <li><?php echo $this->Html->link(__d('setup','Start'), array('action' => 'index')); ?></li>
    <li class="active"><?php echo __d('setup','New Install');?></li>
</ol>
<ul>
    <spacer></spacer>
<p>
    <?php echo __d('setup', 'Follow the following steps to create the database schema and import some initial settings:');?>
</p>   

    <li>
        <?php echo __d('setup','Create the schema');?> - <br/>
        <b>sudo ./Console/cake schema create</b><br/>
        <i>* Answer Y to drop, Y to create</i>
    </li>
    <li><?php echo __d('setup','Import core ingredients');?> - <br/>
        <b>Config/SQL/core_ingredients.sql</b>
    </li>
    <li><?php echo __d('setup','Import sample ingredients (optional)');?> -<br/>
        <b>Config/SQL/sample_ingredients.sql</b>(optional)
    </li>
    <li>
        <?php echo __d('setup', 'Edit the configuration file to set your Email Server/Account')?><br/>
        <b>./Config/email.php</b>
    </li> 
</ul>
<br/>

<?php echo $this->Html->link(__('Continue...'), array( 'action' => 'password'), array('class' => 'btn-primary')); ?>