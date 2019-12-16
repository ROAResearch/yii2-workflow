<?php

use roaresearch\yii2\rmdb\migrations\CreatePersistentEntity;

class m170101_000002_workflow_stage extends CreatePersistentEntity
{
    /**
     * @inhertidoc
     */
    public function getTableName(): string
    {
        return 'workflow_stage';
    }

    /**
     * @inhertidoc
     */
    public function columns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'workflow_id' => $this->normalKey(),
            'position_x' => $this->integer()->notNull()->defaultValue(0),
            'position_y' => $this->integer()->notNull()->defaultValue(0),
            'name' => $this->string(64)->notNull(),
            'initial' => $this->activable(false),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys(): array
    {
        return ['workflow_id' => 'workflow'];
    }

    /**
     * @inhertidoc
     */
    public function compositeUniqueKeys(): array
    {
        return [['workflow_id', 'name']];
    }
}
