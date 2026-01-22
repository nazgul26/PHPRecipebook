<?php
/**
 * Password reset HTML email template
 *
 * @var \App\View\AppView $this
 * @var string $firstName
 * @var string $resetLink
 */
?>
<h2>Hello <?= h($firstName) ?>,</h2>

<p>We received a request to reset your password for your PHP RecipeBook account.</p>

<p>Click the link below to reset your password:</p>

<p style="margin: 20px 0;">
    <a href="<?= h($resetLink) ?>" style="background-color: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">
        Reset Password
    </a>
</p>

<p>Or copy and paste this link into your browser:</p>
<p style="word-break: break-all; color: #666;">
    <?= h($resetLink) ?>
</p>

<p>If you did not request a password reset, please ignore this email. Your password will remain unchanged.</p>

<p style="color: #666; font-size: 12px; margin-top: 30px;">
    This link will expire in 24 hours for security reasons.
</p>
