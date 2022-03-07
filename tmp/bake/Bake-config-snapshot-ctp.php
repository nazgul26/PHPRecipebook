<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Database\Schema\Table;

$constraints = $foreignKeys = $dropForeignKeys = [];
$hasUnsignedPk = $this->Migration->hasUnsignedPrimaryKey($tables);

if ($autoId && $hasUnsignedPk) {
    $autoId = false;
}
?>
<CakePHPBakeOpenTagphp
use Migrations\AbstractMigration;

class <?= $name ?> extends AbstractMigration
{
<?php if (!$autoId): ?>

    public $autoId = false;

<?php endif; ?>
    public function up()
    {
<?php echo $this->element('Migrations.create-tables', ['tables' => $tables, 'autoId' => $autoId, 'useSchema' => false]) ?>
    }

    public function down()
    {
<?php if (!empty($this->Migration->returnedData['dropForeignKeys'])):
            foreach ($this->Migration->returnedData['dropForeignKeys'] as $table => $columnsList):
                $maxKey = count($columnsList) - 1;
        ?>
        $this->table('<?= $table ?>')
<?php foreach ($columnsList as $key => $columns): ?>
            ->dropForeignKey(
                <?= $columns ?>

            )<?= ($key === $maxKey) ? '->save();' : '' ?>

<?php endforeach; ?>

<?php endforeach;
            endif;
        ?>
<?php foreach ($tables as $table): ?>
        $this->table('<?= $table?>')->drop()->save();
<?php endforeach; ?>
    }
}
