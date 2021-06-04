<?php

namespace app\api\models;

use app\models as base;
use roaresearch\yii2\roa\hal\{ARContract, ContractTrait};

/**
 * ROA contract to handle credit_assignment records.
 */
class CreditAssignment extends base\CreditAssignment implements ARContract
{
    use ContractTrait;

    /**
     * @inheritdoc
     */
    protected function processClass(): string
    {
        return Credit::class;
    }
    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'resourceName' => 'assignment',
            'parentSlugRelation' => 'process',
            'idAttributes' => ['user_id'],
        ];
    }
}
