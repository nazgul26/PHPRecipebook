<?php
/**
 * Password reset text email template
 *
 * @var \App\View\AppView $this
 * @var string $firstName
 * @var string $resetLink
 */
?>
Hello <?= $firstName ?>,

We received a request to reset your password for your PHP RecipeBook account.

Click the link below to reset your password:

<?= $resetLink ?>


If you did not request a password reset, please ignore this email. Your password will remain unchanged.

This link will expire in 24 hours for security reasons.
