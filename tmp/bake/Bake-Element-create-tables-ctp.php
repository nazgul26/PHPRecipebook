<?php foreach ($tables as $table => $schema):
    $tableArgForMethods = $useSchema === true ? $schema : $table;
    $tableArgForArray = $useSchema === true ? $table : $schema;

$foreignKeys = [];
$primaryKeysColumns = $this->Migration->primaryKeysColumnsList($tableArgForMethods);
$primaryKeys = $this->Migration->primaryKeys($tableArgForMethods);
$specialPk = $primaryKeys && (count($primaryKeys) > 1 || $primaryKeys[0]['name'] !== 'id' || $primaryKeys[0]['info']['columnType'] !== 'integer') && $autoId;
?>
<?php if ($specialPk): ?>

        $this->table('<?= $tableArgForArray ?>', ['id' => false, 'primary_key' => ['<?= implode("', '", \Cake\Utility\Hash::extract($primaryKeys, '{n}.name')) ?>']])
<?php elseif (!$primaryKeys && $autoId): ?>

        $this->table('<?= $tableArgForArray ?>', ['id' => false])
<?php else: ?>

        $this->table('<?= $tableArgForArray ?>')
<?php endif; ?>
<?php if ($specialPk || !$autoId):
    foreach ($primaryKeys as $primaryKey) :
?>
            ->addColumn('<?= $primaryKey['name'] ?>', '<?= $primaryKey['info']['columnType'] ?>', [<?php
            $columnOptions = $this->Migration->getColumnOption($primaryKey['info']['options']);
            echo $this->Migration->stringifyList($columnOptions, ['indent' => 4]);
            ?>])
<?php endforeach; ?>
<?php if (!$autoId && $primaryKeys): ?>
            ->addPrimaryKey(['<?= implode("', '", \Cake\Utility\Hash::extract($primaryKeys, '{n}.name')) ?>'])
<?php endif; ?>
<?php endif;
foreach ($this->Migration->columns($tableArgForMethods) as $column => $config):
?>
            ->addColumn('<?= $column ?>', '<?= $config['columnType'] ?>', [<?php
            $columnOptions = $this->Migration->getColumnOption($config['options']);
            if ($config['columnType'] === 'boolean' && isset($columnOptions['default']) && $this->Migration->value($columnOptions['default']) !== 'null'):
                $columnOptions['default'] = (bool)$columnOptions['default'];
            endif;
            echo $this->Migration->stringifyList($columnOptions, ['indent' => 4]);
            ?>])
<?php endforeach;
$tableConstraints = $this->Migration->constraints($tableArgForMethods);
if (!empty($tableConstraints)):
    sort($tableConstraints);
    $constraints[$tableArgForArray] = $tableConstraints;

    foreach ($constraints[$tableArgForArray] as $name => $constraint):
        if ($constraint['type'] === 'foreign'):
            $foreignKeys[] = $constraint['columns'];
        endif;
        if ($constraint['columns'] !== $primaryKeysColumns): ?>
            ->addIndex(
                [<?php echo $this->Migration->stringifyList($constraint['columns'], ['indent' => 5]); ?>]<?php echo ($constraint['type'] === 'unique') ? ',' : ''; ?>

<?php if ($constraint['type'] === 'unique'): ?>
                ['unique' => true]
<?php endif; ?>
            )
<?php endif;
    endforeach;
endif;
foreach($this->Migration->indexes($tableArgForMethods) as $index):
    sort($foreignKeys);
    $indexColumns = $index['columns'];
    sort($indexColumns);
    if (!in_array($indexColumns, $foreignKeys)):
        ?>
            ->addIndex(
                [<?php
                    echo $this->Migration->stringifyList($index['columns'], ['indent' => 5]);
                ?>]<?php echo ($index['type'] === 'fulltext') ? ',' : ''; ?>

<?php if ($index['type'] === 'fulltext'): ?>
                ['type' => 'fulltext']
<?php endif; ?>
            )
<?php endif;
endforeach; ?>
            ->create();
<?php endforeach; ?>
<?php if (!empty($constraints)): ?>
<?php echo $this->element('Migrations.add-foreign-keys-from-create', ['constraints' => $constraints]); ?>
<?php endif; ?>
