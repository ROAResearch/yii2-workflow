<?php

use roaresearch\yii2\rmdb\migrations\CreateEntity;

class m170101_000004_workflow_transition_permission extends CreateEntity
{
    /**
     * @inhertidoc
     */
    public function getTableName(): string
    {
        return 'workflow_transition_permission';
    }

    /**
     * @inhertidoc
     */
    public function columns(): array
    {
        return [
            'source_stage_id' => $this->normalKey(),
            'target_stage_id' => $this->normalKey(),
            'permission' => $this->string()->notNull(),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys(): array
    {
        return [
            'transition' => [
                'table' => 'workflow_transition',
                'columns' => [
                    'source_stage_id' => 'source_stage_id',
                    'target_stage_id' => 'target_stage_id',
                ]
            ],
        ];
    }

    /**
     * @inhertidoc
     */
    public function compositePrimaryKeys(): array
    {
        return ['source_stage_id', 'target_stage_id', 'permission'];
    }
}
