<?php 

use Cake\Core\Configure;

if ($isAdmin) :?>
<ol class="breadcrumb">
    <li><?= $this->Html->link(__('Users'), array('action' => 'index')) ?></li>
    <li class="active"><?= __('Edit') ?></li>
</ol>
<?php else : ?>
<h2><?= __('Account Settings') ?></h2>
<?php endif;?>

<div class="users form">
<?= $this->Form->create($user) ?>
	<fieldset>
		<?= $this->Form->hidden('id') ?>
		<?= $this->Form->control('username') ?>
		<?= $this->Form->control('name') ?>
		<?= $this->Form->control('email') ?>
		<?= $this->Form->control('password1', ['type' => 'password', 'label' => ['text' => 'Password']]) ?>
		<?= $this->Form->control('password2', ['type' => 'password', 'label' => ['text' => 'Confirm password']]) ?>
		<?php if ($isAdmin) : ?>
			<?= $this->Form->control('access_level', ['options' => Configure::read('AuthEditRoles')]) ?>
		<?php else : ?>
			<?= $this->Form->hidden('access_level') ?>
		<?php endif ?>
		<?= $this->Form->control('meal_plan_start_day', [
			'options' => [
				'0' => __('Sunday'),
				'1' => __('Monday'),
				'2' => __('Tuesday'),
				'3' => __('Wednesday'),
				'4' => __('Thursday'),
				'5' => __('Friday'),
				'6' => __('Saturday'),
			]
		]) ?>
		<?= $this->Form->control('language', ['options' => Configure::read('Languages')]) ?>
		<?= $this->Form->control('country') ?>
	</fieldset>
	<fieldset>
		<legend><?= __('Additional Settings') ?></legend>
	    <?= $this->Form->control('dinner_reminders_enabled'); ?>
	</fieldset>
    <?= $this->Form->control('last_login',array('disabled' => 'disabled')); ?>
    <?= $this->Form->submit(__('Submit')); ?>
    <?= $this->Form->end() ?>
</div>

