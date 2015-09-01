<?php
$cakeDescription = 'PHPRecipeBook';
?>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <?php 
        echo $this->Html->css("http://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css");
        
        echo $this->Html->script("https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js");
        echo $this->Html->script("http://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js");
        ?>
</head>
<body>
    <div data-role="header">
        <h1><?php echo __('Cookbook');?></h1>
        <a href="./index.php?m=admin&a=index" rel="external" data-icon="gear" class="ui-btn-right">Options</a>
        <div data-role="navbar">
            <ul>
                <li><a href="index.php?m=recipes&a=index_mob"><?php echo __('A-Z');?></a></li>
                <li><a href="index.php?m=recipes&a=search_mob"><?php echo __('Search');?></a></li>
                <li><a href="index.php?m=meals&a=index_mob"><?php echo __('Meals');?></a></li>
                <li><a href="index.php?m=lists&amp;a=current_mob"><?php echo __('List');?></a></li>
                <li><a href="index.php?m=login&a=login_mob"><?php echo __('Sign In');?></a></li>
            </ul>
        </div>
    </div>

    <div data-role="content" id="content">
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>
    </div>
</body>
</html>
