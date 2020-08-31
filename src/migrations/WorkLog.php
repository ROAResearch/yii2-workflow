<?php

namespace roaresearch\yii2\workflow\migrations;

/**
 * Base Migration for creating worklog tables for process.
 */
abstract class WorkLog extends \roaresearch\yii2\rmdb\migrations\CreatePivot
{
    /**
     * @var string suffix attached at the end of the process table.
     */
    public $worklogSuffix = '_worklog';

    /**
     * @return string name of the table to which the worklog will be attached.
     */
    abstract public function getProcessTableName(): string;

    /**
     * @inhertidoc
     */
    public function getTableName(): string
    {
        return $this->getProcessTableName() . $this->worklogSuffix;
    }

    /**
     * @inhertidoc
     */
    public function columns(): array
    {
        return [
            'id' => $this->primaryKey(),
            'process_id' => $this->normalKey(),
            'stage_id' => $this->normalKey(),
            'comment' => $this->text(),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys(): array
    {
        return [
            'stage_id' => 'workflow_stage',
            'process_id' => $this->getProcessTableName(),
        ];
    }
}
