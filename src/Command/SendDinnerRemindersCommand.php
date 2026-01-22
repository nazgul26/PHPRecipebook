<?php
declare(strict_types=1);

namespace App\Command;

use App\Mailer\UserMailer;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\Date;
use Cake\Log\Log;
use Cake\Mailer\MailerAwareTrait;

/**
 * SendDinnerReminders command.
 *
 * Sends nightly emails to users who have a dinner scheduled for the next day.
 */
class SendDinnerRemindersCommand extends Command
{
    use MailerAwareTrait;

    /**
     * @inheritDoc
     */
    public static function getDescription(): string
    {
        return 'Send dinner reminder emails to users with dinners scheduled for tomorrow.';
    }

    /**
     * @inheritDoc
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->addOption('dry-run', [
            'help' => 'Preview what emails would be sent without actually sending them.',
            'boolean' => true,
            'default' => false,
        ]);

        return $parser;
    }

    /**
     * @inheritDoc
     */
    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        $dryRun = $args->getOption('dry-run');
        $tomorrow = Date::tomorrow();
        $tomorrowFormatted = $tomorrow->format('l, F j');

        $io->out("Looking for dinner plans scheduled for {$tomorrowFormatted}...");
        $io->out('');

        // Find the "Dinner" meal_name_id
        $mealNamesTable = $this->fetchTable('MealNames');
        $dinnerMealName = $mealNamesTable->find()
            ->where(['name' => 'Dinner'])
            ->first();

        if (!$dinnerMealName) {
            $io->warning('No "Dinner" meal name found in the database. Exiting.');
            return static::CODE_SUCCESS;
        }

        // Query meal_plans for tomorrow's dinners
        $mealPlansTable = $this->fetchTable('MealPlans');
        $mealPlans = $mealPlansTable->find()
            ->where([
                'MealPlans.meal_name_id' => $dinnerMealName->id,
                'MealPlans.mealday' => $tomorrow->format('Y-m-d'),
            ])
            ->contain([
                'Users',
                'Recipes' => [
                    'IngredientMappings' => [
                        'Ingredients',
                        'Units',
                    ],
                ],
            ])
            ->all();

        if ($mealPlans->isEmpty()) {
            $io->out('No dinner plans found for tomorrow.');
            return static::CODE_SUCCESS;
        }

        // Group recipes by user
        $userRecipes = [];
        foreach ($mealPlans as $mealPlan) {
            $user = $mealPlan->user;

            // Skip if user has opted out of dinner reminders
            if (!$user || !$user->dinner_reminders_enabled) {
                $io->verbose("Skipping user {$user->name} (reminders disabled)");
                continue;
            }

            // Skip if user has no email
            if (empty($user->email)) {
                $io->verbose("Skipping user {$user->name} (no email address)");
                continue;
            }

            $userId = $user->id;
            if (!isset($userRecipes[$userId])) {
                $userRecipes[$userId] = [
                    'user' => $user,
                    'recipes' => [],
                ];
            }
            $userRecipes[$userId]['recipes'][] = $mealPlan->recipe;
        }

        if (empty($userRecipes)) {
            $io->out('No eligible users to notify.');
            return static::CODE_SUCCESS;
        }

        // Send emails to each user
        $emailsSent = 0;
        foreach ($userRecipes as $data) {
            $user = $data['user'];
            $recipes = $data['recipes'];

            $io->out("Processing {$user->name} ({$user->email}):");
            foreach ($recipes as $recipe) {
                $io->out("  - {$recipe->name}");
            }

            if ($dryRun) {
                $io->info('  [DRY RUN] Would send email');
            } else {
                try {
                    $this->getMailer(UserMailer::class)->send('dinnerReminder', [$user, $recipes, $tomorrow]);
                    $io->success('  Email sent successfully');
                    $emailsSent++;
                } catch (\Exception $e) {
                    $io->error("  Failed to send email: {$e->getMessage()}");
                }
            }
            $io->out('');
        }

        if ($dryRun) {
            $io->info("Dry run complete. Would have sent " . count($userRecipes) . " email(s).");
        } else {
            $io->success("Done! Sent {$emailsSent} email(s).");
        }

        return static::CODE_SUCCESS;
    }
}
