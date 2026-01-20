<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * User mailer.
 */
class UserMailer extends Mailer
{
    /**
     * Send password reset email.
     *
     * @param array $user The user data.
     * @param string $resetLink The password reset link.
     * @return void
     */
    public function resetPassword(array $user, string $resetLink): void
    {
        $this
            ->setTo($user['email'])
            ->setSubject('PHPRecipebook Password Reset')
            ->setFrom(['passwordreset@phprecipebook.com' => 'PHP RecipeBook'])
            ->setEmailFormat('both')
            ->setViewVars([
                'firstName' => $user['name'],
                'resetLink' => $resetLink
            ])
            ->viewBuilder()
                ->setTemplate('default')
                ->setLayout('default');
    }
}
