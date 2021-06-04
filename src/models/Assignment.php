<?php

namespace roaresearch\yii2\workflow\models;

use roaresearch\yii2\rmdb\models\Pivot;
use Yii;
use yii\db\ActiveQuery;

/**
 * @property int $process_id
 * @property int $user_id
 *
 * @property Process $process
 */
abstract class Assignment extends Pivot
{
    /**
     * @return string class name for the process this worklog is attached to.
     */
    abstract protected function processClass(): string;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['process_id', 'user_id'], 'required'],
            [['process_id', 'user_id'], 'integer'],
            [
                ['process_id'],
                'exist',
                'targetAttribute' => ['process_id' => 'id'],
                'targetClass' => $this->processClass(),
            ],
            [
                ['user_id'],
                'exist',
                'targetAttribute' => ['user_id' => 'id'],
                'targetClass' => Yii::$app->user->identityClass,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'process_id' => 'Process ID',
            'user_id' => 'User ID',
        ], parent::attributeLabels());
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        is_subclass_of($this->processClass(), Process::class) ||
            throw new InvalidConfigException(
                static::class . '::processClass() must extend '
                    . Process::class
            );

        parent::init();
    }

    /**
     * @return ActiveQuery
     */
    public function getProcess(): ActiveQuery
    {
        return $this->hasOne($this->processClass(), ['id' => 'process_id']);
    }
}
