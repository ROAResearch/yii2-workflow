<?php

use roaresearch\yii2\rmdb\migrations\CreateEntity;

class m170101_000003_workflow_transition extends CreateEntity
{
    /**
     * @inhertidoc
     */
    public function getTableName(): string
    {
        return 'workflow_transition';
    }

    /**
     * @inhertidoc
     */
    public function columns(): array
    {
        return [
            'source_stage_id' => $this->normalKey(),
            'target_stage_id' => $this->normalKey(),
            'name' => $this->string(64)->notNull(),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys(): array
    {
        return [
            'source_stage_id' => 'workflow_stage',
            'target_stage_id' => 'workflow_stage',
        ];
    }

    /**
     * @inhertidoc
     */
    public function compositePrimaryKeys(): array
    {
        return ['source_stage_id', 'target_stage_id'];
    }

    /**
     * @inhertidoc
     */
    public function compositeUniqueKeys(): array
    {
        return [['source_stage_id', 'name']];
    }
}
