<?php

use roaresearch\yii2\workflow\migrations\Assignment;

class m171130_000004_credit_assignment extends Assignment
{
    public function getProcessTableName(): string
    {
        return 'credit';
    }
}
