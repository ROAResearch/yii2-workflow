<?php

namespace app\models;

use roaresearch\yii2\workflow\models\Stage;

class CreditWorkLog extends \roaresearch\yii2\workflow\models\WorkLog
{
    /**
     * @inheritdoc
     */   public static function tableName()
    {
        return '{{%credit_worklog}}';
    }

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
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['stage_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Stage::class,
                'targetAttribute' => ['workflow_id' => 'id'],
                'on' => [self::SCENARIO_INITIAL],
                'filter' => function ($q) {
                    if (!$this->process->hasErrors()) {
                        $q->andWhere([
                            'workflow_id' => $this->process->workflow_id,
                        ]);
                    }
                }
                'message' => 'Stage "{value}" does not belong to the workflow.",
            ],
        ]);
    }
}
