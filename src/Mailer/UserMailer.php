<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\User;
use Cake\I18n\Date;
use Cake\Mailer\Mailer;
use function Cake\Core\env;

/**
 * User mailer.
 */
class UserMailer extends Mailer
{
    /**
     * Get the configured from address for emails.
     *
     * @return array The from address as [email => name].
     */
    protected function getFromAddress(): array
    {
        $fromEmail = env('EMAIL_FROM_ADDRESS', 'noreply@phprecipebook.com');
        $fromName = env('EMAIL_FROM_NAME', 'PHP RecipeBook');

        return [$fromEmail => $fromName];
    }

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
            ->setFrom($this->getFromAddress())
            ->setEmailFormat('both')
            ->setViewVars([
                'firstName' => $user['name'],
                'resetLink' => $resetLink,
            ])
            ->viewBuilder()
                ->setTemplate('password_reset')
                ->setLayout('default');
    }

    /**
     * Send dinner reminder email.
     *
     * @param \App\Model\Entity\User $user The user entity.
     * @param array $recipes Array of recipe entities with ingredient mappings.
     * @param \Cake\I18n\Date $date The date of the dinner.
     * @return void
     */
    public function dinnerReminder(User $user, array $recipes, Date $date): void
    {
        $dateFormatted = $date->format('l, F j');

        $this
            ->setTo($user->email)
            ->setSubject("Dinner Reminder for {$dateFormatted}")
            ->setFrom($this->getFromAddress())
            ->setEmailFormat('both')
            ->setViewVars([
                'user' => $user,
                'recipes' => $recipes,
                'date' => $date,
                'dateFormatted' => $dateFormatted,
            ])
            ->viewBuilder()
                ->setTemplate('dinner_reminder')
                ->setLayout('default');
    }
}
