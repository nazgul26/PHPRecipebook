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
	<?php
		echo $this->Html->meta('icon');
		
                echo $this->Html->css("https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css");
                echo $this->Html->css("toastr.min.css");
                echo $this->Html->css("jquery.qtip");
                echo $this->Html->css('cake.generic');
                echo $this->Html->css('default');
                echo $this->Html->css('print');
                
                echo $this->Html->script("https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js");
                echo $this->Html->script("https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js");
                echo $this->Html->script("toastr.min.js");
                echo $this->Html->script("jquery.qtip.js");
                echo $this->Html->script("default");
                
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
                
                $baseUrl = Router::url('/');
	?>
    
</head>
<body>
    <script type="text/javascript">
        $(function() {
            initApplication("<?php echo $baseUrl;?>");
        });
        // Global Variables
        var applicationContext = "recipes"; // Default context
    </script>
    
    <div id="container">
        <div id="header">

        </div>
        
        <div id="recipeLinkBoxContainer"></div>
            
        <div id="main" class="constrain borderStyle">
            <nav id="navigation-menu">
                <ul>
                    <li><a href="<?php echo $baseUrl;?>Recipes" class="ajaxNavigation" 
                           title="<?php echo __('Browse your recipes');?>"><?php echo __('Recipes'); ?></a></li>
                           
                    <?php if ($loggedIn) : ?>
                    <li><a href="<?php echo $baseUrl;?>MealPlans" class="ajaxNavigation" 
                           title="<?php echo __('Manage your meal plans');?>"><?php echo __('Meal Planner'); ?></a></li>
                           
                    <li><a href="<?php echo $baseUrl;?>ShoppingLists" class="ajaxNavigation" 
                           title="<?php echo __('Create or Edit a shopping list');?>"><?php echo __('Shopping List');?></a></li>
                           
                    <li><a href="<?php echo $baseUrl;?>Ingredients" class="ajaxNavigation higherRes" 
                           title="<?php echo __('Ingredients used in recipes');?>"><?php echo __('Ingredients'); ?></a></li>
                           
                    <?php endif; ?>
                    <li><a href="<?php echo $baseUrl;?>Restaurants" class="ajaxNavigation higherRes" 
                           title="<?php echo __('List of your restaurants');?>"><?php echo __('Restaurants');?></a></li>
                    <?php if ($loggedIn && $isAdmin) : ?>
                    <li><a href="<?php echo $baseUrl;?>Users" class="ajaxNavigation higherRes" 
                           title="<?php echo __('Administer Users');?>"><?php echo __('Users');?></a></li>
                           
                    <?php endif; ?>
                    <li><div id="searchHolder">
                        <form id="searchEverythingForm">
                          <span>
                              <input type="text" class="searchTextBox" placeholder="Search Recipes" />
                              <img src="<?php echo $baseUrl;?>img/clearBtn.png"  class="cancelBtn"/>
                          </span>
                        </form>
                    </li>
                    <?php if (!$loggedIn) : ?>
                        <li>
                            <a href="<?php echo $baseUrl;?>Users/login" id="signInButton" 
                               title="<?php echo __('Sign in with your existing account');?>"><?php echo __('Sign in')?></a>
                        </li>
                        <?php if ($allowAccountCreation) :?>
                        <li>
                            <a href="<?php echo $baseUrl;?>Users/add" id="signInButton" 
                               title="<?php echo __('Create a new account');?>"><?php echo __('Create Account')?></a>
                        </li>
                        <?php endif;?>
                    <?php else: ?>
                    <li>
                        <a href="<?php echo $baseUrl;?>Users/logout" title="<?php echo __('Logout');?>"><?php echo __('Logout')?></a>
                    </li>
                    <li id="settingsLink">
                        <a href="<?php echo $baseUrl;?>Users/edit/<?php echo AuthComponent::user('id');?>" 
                           title="<?php echo __('Edit your Account settings');?>"
                           class="ajaxNavigation">
                            <?php echo $this->Html->image('two_gears.png', array('alt' => 'Settings'));?>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </nav> 

            <div id="content">
                    <?php echo $this->Session->flash(); ?>

                    <?php echo $this->fetch('content'); ?>
            </div>
        
            <div id="footer">

            </div>
        </div>
    </div>
    <div id="editIngredientDialog" class="dialog" width="600" height="610" title="<?php echo __('Ingredient');?>"/>    
    <div id="editLocationDialog" class="dialog" width="600" height="240" title="<?php echo __('Location');?>"/>
    <div id="editUnitDialog" class="dialog" width="600" height="400" title="<?php echo __('Unit');?>"/>
    <div id="editCoreIngredientDialog" class="dialog" width="600" height="400" title="<?php echo __('Core Ingredients');?>"/>
    <div id="editRestaurantDialog" class="dialog" width="600" height="800" title="<?php echo __('Restaurant');?>"/>
    <div id="editPriceRangesDialog" class="dialog" width="600" height="200" title="<?php echo __('Price Ranges');?>"/>
    <div id="editEthnicityDialog" class="dialog" width="600" height="200" title="<?php echo __('Ethnicity');?>"/>
    <div id="editBaseTypeDialog" class="dialog" width="600" height="200" title="<?php echo __('Base Type');?>"/>
    <div id="editCourseDialog" class="dialog" width="600" height="200" title="<?php echo __('Course');?>"/>
    <div id="editPrepTimeDialog" class="dialog" width="600" height="200" title="<?php echo __('Preparation Time');?>"/>
    <div id="editPrepMethodDialog" class="dialog" width="600" height="200" title="<?php echo __('Preparation Method');?>"/>
    <div id="editDifficultyDialog" class="dialog" width="600" height="200" title="<?php echo __('Difficulty');?>"/>
    <div id="editSourceDialog" class="dialog" width="600" height="500" title="<?php echo __('Source');?>"/>
    <div id="editMealDialog" class="dialog" width="700" height="500" title="<?php echo __('Meal');?>"/>
</body>
</html>
