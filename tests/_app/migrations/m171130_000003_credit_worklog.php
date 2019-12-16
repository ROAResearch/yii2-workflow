<?php

use roaresearch\yii2\workflow\migrations\WorkLog;

class m171130_000003_credit_worklog extends WorkLog
{
    public function getProcessTableName(): string
    {
        return 'credit';
    }
}
