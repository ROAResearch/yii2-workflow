<?php

namespace roaresearch\yii2\workflow\models;

use roaresearch\yii2\rmdb\SoftDeleteActiveQuery;
use yii\db\ActiveQuery;

/**
 * Model class for table `{{%workflow}}`
 *
 * @property integer $id
 * @property string $name
 *
 * @property Stage[] $stages
 */
class Workflow extends \roaresearch\yii2\rmdb\models\PersistentEntity
{
    /**
     * @var string full class name of the model to be used for the relation
     * `getStages()`.
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%workflow}}';
    }

    /**
     * @inheritdoc
     */
    protected function attributeTypecast(): ?array
    {
        return parent::attributeTypecast() + ['id' => 'integer'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'min' => 6],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'id' => 'ID',
            'name' => 'Workflow name',
        ], parent::attributeLabels());
    }

    /**
     * @return ActiveQuery
     */
    public function getStages(): SoftDeleteActiveQuery
    {
        return $this->hasMany($this->stageClass, ['workflow_id' => 'id'])
            ->inverseOf('workflow');
    }

    /**
     * @return ActiveQuery
     */
    public function getDetailStages(): ActiveQuery
    {
        $query = $this->getStages();
        $query->multiple = false;

        return $query->select([
            'workflow_id',
            'totalStages' => 'count(distinct id)',
        ])->asArray()
        ->inverseOf(null)
        ->groupBy('workflow_id');
    }

    /**
     * @return int
     */
    public function getTotalStages(): int
    {
        return (int)$this->detailStages['totalStages'];
    }

    /**
     * @inheritdoc
     */
    protected function softDeleteConf(): array
    {
        return parent::softDeleteConf() + [
            'allowDeleteCallback' => function ($record) {
                return !$record->getStages()->exists();
            },
        ];
    }
}
