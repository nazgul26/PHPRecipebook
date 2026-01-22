<?php
/**
 * Dinner reminder email template (plain text version)
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array $recipes
 * @var \Cake\I18n\Date $date
 * @var string $dateFormatted
 */
?>
Hello <?= $user->name ?>,

This is a friendly reminder that you have dinner planned for <?= $dateFormatted ?>.

<?php foreach ($recipes as $recipe) : ?>
-------------------------------------------
<?= $recipe->name ?>

<?php if (!empty($recipe->ingredient_mappings)) : ?>
Ingredients:
<?php foreach ($recipe->ingredient_mappings as $mapping) : ?>
<?php
$parts = [];
if ($mapping->quantity) {
    $parts[] = $mapping->quantity;
}
if ($mapping->unit && $mapping->unit->name) {
    $parts[] = $mapping->unit->name;
}
if ($mapping->ingredient && $mapping->ingredient->name) {
    $parts[] = $mapping->ingredient->name;
}
if ($mapping->qualifier) {
    $parts[] = '(' . $mapping->qualifier . ')';
}
?>
  - <?= implode(' ', $parts) ?>

<?php endforeach; ?>
<?php else : ?>
No ingredients listed for this recipe.
<?php endif; ?>

<?php endforeach; ?>
-------------------------------------------

Enjoy your meal!

You are receiving this email because you have dinner reminder emails enabled in your account settings. You can disable these reminders by updating your preferences in PHP RecipeBook.
