Dear <?php echo $firstName;?>,

<p>This email was sent automatically by PHPRecipeBook in response to your request to reset your password. </p>
	
<p>To reset your password and access your account, either click on the link below or copy and paste the following link (expires in 1 hour) into the address bar of your browser:</p>
<p>
    <a href="<?php echo $resetLink;?>"><?php echo $resetLink;?></a>
</p>