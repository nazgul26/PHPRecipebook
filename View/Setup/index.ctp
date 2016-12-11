<spacer/>
<?php

if (!Configure::read('App.setupMode')):
	throw new NotFoundException();
endif;

App::uses('Debugger', 'Utility');
?>
<h2><?php echo __d('setup', 'Welcome to PHPRecipeBook ') . Configure::read('App.version'); ?></h2>
<p>
    <?php echo __d('setup','This is the setup page for the application.  The following messages will indicate if your server has been properly setup.');?>
</p>
<?php
if (Configure::read('debug') > 0):
	Debugger::checkSecurityKeys();
endif;
?>
<p>
<?php
	if (version_compare(PHP_VERSION, '5.2.8', '>=')):
		echo '<span class="notice success">';
			echo __d('setup', 'Your version of PHP is 5.2.8 or higher.');
		echo '</span>';
	else:
		echo '<span class="notice">';
			echo __d('setup', 'Your version of PHP is too low. You need PHP 5.2.8 or higher to use CakePHP.');
		echo '</span>';
	endif;
?>
</p>
<p>
	<?php
		if (is_writable(TMP)):
			echo '<span class="notice success">';
				echo __d('setup', 'Your tmp directory is writable.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('setup', 'Your tmp directory is NOT writable.');
			echo '</span>';
		endif;
	?>
</p>
<p>
	<?php
		$settings = Cache::settings();
		if (!empty($settings)):
			echo '<span class="notice success">';
				echo __d('setup', 'The %s is being used for core caching. To change the config edit %s', '<em>'. $settings['engine'] . 'Engine</em>', 'APP/Config/core.php');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('setup', 'Your cache is NOT working. Please check the settings in %s', 'APP/Config/core.php');
			echo '</span>';
		endif;
	?>
</p>
<p>
	<?php
		$filePresent = null;
		if (file_exists(APP . 'Config' . DS . 'database.php')):
			echo '<span class="notice success">';
				echo __d('setup', 'Your database configuration file is present.');
				$filePresent = true;
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo __d('setup', 'Your database configuration file is NOT present.');
				echo '<br/>';
				echo __d('setup', 'Rename %s to %s', 'APP/Config/database.php.default', 'APP/Config/database.php');
			echo '</span>';
		endif;
	?>
</p>
<?php
if (isset($filePresent)):
	App::uses('ConnectionManager', 'Model');
	try {
		$connected = ConnectionManager::getDataSource('default');
	} catch (Exception $connectionError) {
		$connected = false;
		$errorMsg = $connectionError->getMessage();
		if (method_exists($connectionError, 'getAttributes')):
			$attributes = $connectionError->getAttributes();
			if (isset($errorMsg['message'])):
				$errorMsg .= '<br />' . $attributes['message'];
			endif;
		endif;
	}
?>
<p>
	<?php
		if ($connected && $connected->isConnected()):
			echo '<span class="notice success">';
				echo __d('setup', 'CakePHP is able to connect to the database.');
			echo '</span>';
		else:
			echo '<span class="notice">';
				echo 'CakePHP is NOT able to connect to the database. Check that: ';
                                echo "<br/>";
                                echo __d('setup', '1. Installed the appropriate PHP db module (i.e. php-mysql, php-pgsql)') . "<br/>";
                                echo __d('setup', '2. The database has been created and you can connect to it') . "<br/>";
                                echo __d('setup', '3. Have the correct username password in database.php config file') . "<br/>";
				echo '<br />';
				echo __d('setup','error Message:' ) . $errorMsg;
			echo '</span>';
		endif;
	?>
</p>
<?php endif; ?>
<?php
	App::uses('Validation', 'Utility');
	if (!Validation::alphaNumeric('cakephp')):
		echo '<p><span class="notice">';
			echo __d('setup', 'PCRE has not been compiled with Unicode support.');
			echo '<br/>';
			echo __d('setup', 'Recompile PCRE with Unicode support by adding <code>--enable-unicode-properties</code> when configuring');
		echo '</span></p>';
	endif;
?>
<p>
<?php
if (file_exists(WWW_ROOT . 'css' . DS . 'cake.generic.css')):
?>
<div class="notice">
    <?php echo __d('setup', 'URL rewriting might not properly configured on your server.  '); ?>
    <ol style="padding-left: 1em;">
        <li><a target="_blank" href="http://book.cakephp.org/2.0/en/installation/url-rewriting.html">Help me configure it</a></li>
        <li><a target="_blank" href="http://book.cakephp.org/2.0/en/development/configuration.html#cakephp-core-configuration">I don't / can't use URL rewriting</a></li>
    </ol>
    <br/>
    
    <p>
        <i><?php echo __d('setup', 'If you have already configured rewriting or a base URL and still see this warning you can try to continue the setup.  Detection of this feature sometimes is not correct.'); ?></i>
    </p>
</div>
<?php
endif;
?>
</p>
<p>
    <?php echo __d('setup','After correcting any issues above you can continue the setup process.');?>
</p>
<?php echo $this->Html->link(__('New Install'), array( 'action' => 'database'), array('class' => 'btn-primary')); ?>
<?php echo $this->Html->link(__('Upgrade'), array( 'action' => 'upgrade'), array('class' => 'btn-primary')); ?>
