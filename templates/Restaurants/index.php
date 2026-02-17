<script type="text/javascript">
    setSearchBoxTarget('Restaurants');

    document.addEventListener("saved.restaurant", function() {
        closeModal('editRestaurantDialog');
        ajaxGet('restaurants');
    });

    // Address popovers
    document.querySelectorAll('.addressPopover').forEach(function(el) {
        var addressEl = el.closest('td').querySelector('address');
        if (addressEl) {
            new bootstrap.Popover(el, {
                content: addressEl.innerHTML,
                html: true,
                trigger: 'click',
                placement: 'bottom'
            });
        }
    });
</script>
<div class="restaurants index">
	<h2><?= __('Restaurants') ?></h2>
    <?php if ($loggedIn): ?>
    <div class="actions-bar">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> ' . __('Add Restaurant'), ['action' => 'edit'], ['escape' => false, 'class' => 'btn btn-primary btn-sm ajaxLink', 'targetId' => 'editRestaurantDialog']) ?>
        <div class="dropdown d-inline-block">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear"></i> <?= __('Manage') ?>
            </button>
            <ul class="dropdown-menu">
                <li><?= $this->Html->link(__('List Price Ranges'), ['controller' => 'price-ranges', 'action' => 'index'], ['class' => 'dropdown-item ajaxLink']) ?></li>
                <li><?= $this->Html->link('<i class="bi bi-plus me-1"></i>' . __('Add Price Range'), ['controller' => 'price-ranges', 'action' => 'edit'], ['escape' => false, 'class' => 'dropdown-item ajaxLink', 'targetId' => 'editPriceRangesDialog']) ?></li>
            </ul>
        </div>
    </div>
    <?php endif;?>
	<table class="table table-hover table-striped align-middle">
	<thead>
	<tr>
        <?php if ($loggedIn) :?>
        <th class="actions"><?= __('Actions') ?></th>
        <?php endif;?>
        <th><?= $this->Paginator->sort('name') ?></th>
        <th><?= $this->Paginator->sort('phone') ?></th>
        <th><?= __('Address') ?></th>
        <th><?= $this->Paginator->sort('hours') ?></th>
        <th><?= __('Price') ?></th>
        <th><?= $this->Paginator->sort('comments') ?></th>
        <th><?= $this->Paginator->sort('user_id') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($restaurants as $restaurant): ?>
	<tr>
        <?php if ($loggedIn) :?>
        <td class="actions">
        <?php if ($isAdmin || $loggedInuserId == $restaurant->user->id):?>
            <?= $this->Html->link(__('Edit'), array('action' => 'edit', $restaurant->id), array('class' => 'ajaxLink', 'targetId' => 'editRestaurantDialog')) ?>
            <?= $this->Form->postLink(__('Delete'), array('action' => 'delete', $restaurant->id), ['confirm' => __('Are you sure you want to delete # {0}?', $restaurant->id)]) ?>
        <?php endif;?>
        </td>
        <?php endif;?>
        <td>
            <?php if (!empty($restaurant->website)) { ?>
                <a href="<?= $restaurant->website ?>" target="_blank"><?= $restaurant->name ?></a>
            <?php } else {?>
                <?= $restaurant->name ?>
            <?php } ?>
        </td>
        <td><?= h($restaurant->phone) ?>&nbsp;</td>
        <td>
            <i class="bi bi-geo-alt addressPopover" style="cursor: pointer;" title="<?= __('View Address') ?>"></i>
            <address style="display: none;">
                <?= h($restaurant->street) ?><br/>
                <?= h($restaurant->city) ?>, <?= h($restaurant->state) ?> <?= h($restaurant->zip) ?><br/>
                <?= h($restaurant->country) ?>
            </address>
        </td>
        <td><?= $restaurant->hours ?>&nbsp;</td>
        <td><?= $restaurant->name ?></td>
        <td><?= $restaurant->comments ?>&nbsp;</td>
        <td>
        <?php
        if ($isAdmin) {
            echo $this->Html->link($restaurant->user->name, array('controller' => 'users', 'action' => 'view', $restaurant->user->id));
        } else {
            echo $restaurant->user->name;
        }?>
        </td>
    </tr>
<?php endforeach; ?>
    </tbody>
	</table>
    <?= $this->element('pager') ?>
</div>
