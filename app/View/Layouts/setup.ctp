<?php
$cakeDescription = __d('cake_dev', 'PHPRecipeBook');
?>

<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
                echo $this->Html->css('cake.generic');
                echo $this->Html->css('default');
                echo $this->Html->css('print');
                
                echo $this->Html->script("https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js");
                echo $this->Html->script("https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js");
                echo $this->Html->script("jquery.qtip.js");
                echo $this->Html->script("default");
                
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
                

	?>
    
</head>
<body>
    <div id="container" class="setup">
        <div id="main" class="constrain borderStyle">
 
            <div id="content">
                    <?php echo $this->Session->flash(); ?>

                    <?php echo $this->fetch('content'); ?>
            </div>
        </div>
    </div>
</body>
</html>
