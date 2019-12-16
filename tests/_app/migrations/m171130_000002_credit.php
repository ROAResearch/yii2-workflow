<?php

use roaresearch\yii2\rmdb\migrations\CreatePersistentEntity;

class m171130_000002_credit extends CreatePersistentEntity
{
    public function getTableName(): string
    {
        return 'credit';
    }

    public function columns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'workflow_id' => $this->normalKey(),
        ];
    }

    public function foreignKeys(): array
    {
        return [
            'workflow_id' => ['table' => 'workflow']
        ];
    }
}
