<?php
/**
 * Dinner reminder email template (HTML version)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array $recipes
 * @var \Cake\I18n\Date $date
 * @var string $dateFormatted
 */
?>
<h2>Hello <?= h($user->name) ?>,</h2>

<p>This is a friendly reminder that you have dinner planned for <strong><?= h($dateFormatted) ?></strong>.</p>

<?php foreach ($recipes as $recipe) : ?>
<div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
    <h3 style="margin-top: 0; color: #333;"><?= h($recipe->name) ?></h3>

    <?php if (!empty($recipe->ingredient_mappings)) : ?>
    <h4 style="margin-bottom: 10px;">Ingredients:</h4>
    <ul style="margin: 0; padding-left: 20px;">
        <?php foreach ($recipe->ingredient_mappings as $mapping) : ?>
        <li>
            <?php
            $parts = [];
            if ($mapping->quantity) {
                $parts[] = h($mapping->quantity);
            }
            if ($mapping->unit && $mapping->unit->name) {
                $parts[] = h($mapping->unit->name);
            }
            if ($mapping->ingredient && $mapping->ingredient->name) {
                $parts[] = h($mapping->ingredient->name);
            }
            if ($mapping->qualifier) {
                $parts[] = '(' . h($mapping->qualifier) . ')';
            }
            echo implode(' ', $parts);
            ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php else : ?>
    <p><em>No ingredients listed for this recipe.</em></p>
    <?php endif; ?>
</div>
<?php endforeach; ?>

<p>Enjoy your meal!</p>

<p style="color: #666; font-size: 12px;">
    You are receiving this email because you have dinner reminder emails enabled in your account settings.
    You can disable these reminders by updating your preferences in PHP RecipeBook.
</p>
