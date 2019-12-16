<?php

use roaresearch\yii2\rmdb\migrations\CreatePersistentEntity;

class m170101_000001_workflow extends CreatePersistentEntity
{
    /**
     * @inhertidoc
     */
    public function getTableName(): string
    {
        return 'workflow';
    }

    /**
     * @inhertidoc
     */
    public function columns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->unique()->notNull(),
        ];
    }
}
