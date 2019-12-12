<?php

namespace app\models;

class CreditAssignment extends \roaresearch\yii2\workflow\models\Assignment
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%credit_assignment}}';
    }
 
    /**
     * @inheritdoc
     */
    protected function processClass(): string
    {
        return Credit::class;
    }
}
