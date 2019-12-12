<?php

namespace app\models;

use Yii;
use roaresearch\yii2\workflow\models\Workflow;

/**
 * This is the model class for table `{{%credit}}`.
 *
 * @property integer $id
 * @property string $credit
 */
class Credit extends \roaresearch\yii2\workflow\models\Process
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%credit}}';
    }

    protected function assignmentClass(): string
    {
        return CreditAssignment::class;
    }

    protected function workLogClass(): string
    {
        return CreditWorklog::class;
    }

    public function getWorkflowId(): int
    {
        return $this->workflow_id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['workflow_id'], 'required'],
            [
                ['workflow_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Workflow::class,
                'targetAttribute' => ['workflow_id' => 'id'],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'workflow_id' => Yii::t('app', 'Workflow ID'),
        ];
    }
}
