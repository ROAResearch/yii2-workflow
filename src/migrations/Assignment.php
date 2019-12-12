<?php

namespace roaresearch\yii2\workflow\migrations;

/**
 * Base Migration for creating assignment tables for process.
 */
abstract class Assignment extends \roaresearch\yii2\rmdb\migrations\CreatePivot
{
    /**
     * @var string suffix attached at the end of the process table.
     */
    public $assignmentSuffix = '_assignment';

    /**
     * @return string name of the table to which the assignment will be attached.
     */
    abstract public function getProcessTableName(): string;

    /**
     * @inhertidoc
     */
    public function getTableName(): string
    {
        return $this->getProcessTableName() . $this->assignmentSuffix;
    }

    /**
     * @inhertidoc
     */
    public function columns(): array
    {
        return [
            'process_id' => $this->normalKey(),
            'user_id' => $this->normalKey(),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys(): array
    {
        return [
           'process_id' => $this->getProcessTableName(),
        ];
    }
 
    /**
     * @inhertidoc
     */
    public function compositePrimaryKeys(): array
    {
        return ['process_id', 'user_id'];
    }
}
