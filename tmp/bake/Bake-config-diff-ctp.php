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

$tables = $data['fullTables'];
unset($data['fullTables']);
$constraints = [];

$hasUnsignedPk = $this->Migration->hasUnsignedPrimaryKey($tables['add']);

$autoId = true;
if ($hasUnsignedPk) {
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
<?php foreach ($data as $tableName => $tableDiff):
            $hasRemoveFK = !empty($tableDiff['constraints']['remove']) || !empty($tableDiff['indexes']['remove']);
        ?>
<?php if ($hasRemoveFK): ?>
        $this->table('<?= $tableName ?>')
<?php endif; ?>
<?php if (!empty($tableDiff['constraints']['remove'])): ?>
<?php foreach ($tableDiff['constraints']['remove'] as $constraintName => $constraintDefinition): ?>
            ->dropForeignKey([], '<?= $constraintName ?>')
<?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($tableDiff['indexes']['remove'])): ?>
<?php foreach ($tableDiff['indexes']['remove'] as $indexName => $indexDefinition): ?>
            ->removeIndexByName('<?= $indexName ?>')
<?php endforeach; ?>
<?php endif; ?>
<?php if ($hasRemoveFK): ?>
            ->update();
<?php endif; ?>
<?php if (!empty($tableDiff['columns']['remove']) || !empty($tableDiff['columns']['changed'])): ?>

        <?= $this->Migration->tableStatement($tableName, true) ?>

<?php if (!empty($tableDiff['columns']['remove'])): ?>
<?php foreach ($tableDiff['columns']['remove'] as $columnName => $columnDefinition): ?>
            ->removeColumn('<?= $columnName ?>')
<?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($tableDiff['columns']['changed'])): ?>
<?php foreach ($tableDiff['columns']['changed'] as $columnName => $columnAttributes):
            $type = $columnAttributes['type'];
            unset($columnAttributes['type']);
            $columnAttributes = $this->Migration->getColumnOption($columnAttributes);
            $columnAttributes = $this->Migration->stringifyList($columnAttributes, ['indent' => 4]);
            if (!empty($columnAttributes)): ?>
            ->changeColumn('<?= $columnName ?>', '<?= $type ?>', [<?= $columnAttributes ?>])
<?php else: ?>
            ->changeColumn('<?= $columnName ?>', '<?= $type ?>')
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if (isset($this->Migration->tableStatements[$tableName])): ?>
            ->update();
<?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php if (!empty($tables['add'])): ?>
<?php echo $this->element('Migrations.create-tables', ['tables' => $tables['add'], 'autoId' => $autoId, 'useSchema' => true]) ?>
<?php endif; ?>
<?php foreach ($data as $tableName => $tableDiff): ?>
<?php if (!empty($tableDiff['columns']['add']) || !empty($tableDiff['indexes']['add'])): ?>

        <?= $this->Migration->tableStatement($tableName, true) ?>

<?php if (!empty($tableDiff['columns']['add'])): ?>
<?php echo $this->element('Migrations.add-columns', ['columns' => $tableDiff['columns']['add']]) ?>
<?php endif; ?>
<?php if (!empty($tableDiff['indexes']['add'])): ?>
<?php echo $this->element('Migrations.add-indexes', ['indexes' => $tableDiff['indexes']['add']]) ?>
<?php endif;
            if (isset($this->Migration->tableStatements[$tableName])): ?>
            ->update();
<?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php foreach ($data as $tableName => $tableDiff): ?>
<?php if (!empty($tableDiff['constraints']['add'])): ?>
<?php echo $this->element(
                'Migrations.add-foreign-keys',
                ['constraints' => $tableDiff['constraints']['add'], 'table' => $tableName]
            ); ?>
<?php endif; ?>
<?php endforeach; ?>
<?php if (!empty($tables['remove'])): ?>
<?php foreach ($tables['remove'] as $tableName => $table): ?>

        $this->table('<?= $tableName ?>')->drop()->save();
<?php endforeach; ?>
<?php endif; ?>
    }

    public function down()
    {
<?php $constraints = [];
        $emptyLine = false;
        if (!empty($this->Migration->returnedData['dropForeignKeys'])):
            foreach ($this->Migration->returnedData['dropForeignKeys'] as $table => $columnsList):
                $maxKey = count($columnsList) - 1;
                if ($emptyLine === true): ?>

<?php else:
                    $emptyLine = true;
                endif; ?>
        $this->table('<?= $table ?>')
<?php foreach ($columnsList as $key => $columns): ?>
            ->dropForeignKey(
                <?= $columns ?>

            )<?= ($key === $maxKey) ? '->save();' : '' ?>

<?php endforeach; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($tables['remove'])): ?>
<?php echo $this->element('Migrations.create-tables', ['tables' => $tables['remove'], 'autoId' => $autoId, 'useSchema' => true]) ?>
<?php endif; ?>
<?php foreach ($data as $tableName => $tableDiff):
                unset($this->Migration->tableStatements[$tableName]);
                if (!empty($tableDiff['indexes']['add'])): ?>

        $this->table('<?= $tableName ?>')
<?php foreach ($tableDiff['indexes']['add'] as $indexName => $index): ?>
            ->removeIndexByName('<?= $indexName ?>')
<?php endforeach ?>
            ->update();
<?php endif; ?>
<?php if (!empty($tableDiff['columns']['remove']) ||
            !empty($tableDiff['columns']['changed']) ||
            !empty($tableDiff['columns']['add']) ||
            !empty($tableDiff['indexes']['remove'])
        ): ?>

        <?= $this->Migration->tableStatement($tableName, true) ?>

<?php endif; ?>
<?php if (!empty($tableDiff['columns']['remove'])): ?>
<?php echo $this->element('Migrations.add-columns', ['columns' => $tableDiff['columns']['remove']]) ?>
<?php endif; ?>
<?php if (!empty($tableDiff['columns']['changed'])):
            $oldTableDef = $dumpSchema[$tableName];
            foreach ($tableDiff['columns']['changed'] as $columnName => $columnAttributes):
            $columnAttributes = $oldTableDef->getColumn($columnName);
            $type = $columnAttributes['type'];
            unset($columnAttributes['type']);
            $columnAttributes = $this->Migration->getColumnOption($columnAttributes);
            $columnAttributes = $this->Migration->stringifyList($columnAttributes, ['indent' => 4]);
            if (!empty($columnAttributes)): ?>
            ->changeColumn('<?= $columnName ?>', '<?= $type ?>', [<?= $columnAttributes ?>])
<?php else: ?>
            ->changeColumn('<?= $columnName ?>', '<?= $type ?>')
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($tableDiff['columns']['add'])): ?>
<?php foreach ($tableDiff['columns']['add'] as $columnName => $columnAttributes): ?>
            ->removeColumn('<?= $columnName ?>')
<?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($tableDiff['indexes']['remove'])): ?>
<?php echo $this->element('Migrations.add-indexes', ['indexes' => $tableDiff['indexes']['remove']]) ?>
<?php endif;
            if (isset($this->Migration->tableStatements[$tableName])): ?>
            ->update();
<?php endif; ?>
<?php endforeach; ?>
<?php foreach ($data as $tableName => $tableDiff): ?>
<?php if (!empty($tableDiff['constraints']['remove'])): ?>
<?php echo $this->element(
                    'Migrations.add-foreign-keys',
                    ['constraints' => $tableDiff['constraints']['remove'], 'table' => $tableName]
                ); ?>
<?php endif; ?>
<?php endforeach; ?>
<?php if (!empty($tables['add'])): ?>
<?php foreach ($tables['add'] as $tableName => $table): ?>

        $this->table('<?= $tableName ?>')->drop()->save();
<?php endforeach; ?>
<?php endif; ?>
    }
}

