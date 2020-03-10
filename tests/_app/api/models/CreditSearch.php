<?php

namespace app\api\models;

use roaresearch\yii2\roa\ResourceSearch;
use roaresearch\yii2\workflow\models\Stage;
use yii\data\ActiveDataProvider;

class CreditSearch extends Credit implements ResourceSearch
{
    /**
     * @inhertidoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['activeStage']);
    }

    /**
     * @inhertidoc
     */
    protected $autogenerateInitialWorklog = false;

    /**
     * @inhertidoc
     */
    public function rules()
    {
        return [
            [['created_by', 'activeStage'], 'integer'],
            [
                ['activeStage'],
                'exist',
                'targetAttribute' => ['stageActiveStage' => 'id'],
                'targetClass' => Stage::class,
                'message' => 'Stage not registered.'
            ],
        ];
    }

    /**
     * @inhertidoc
     */
    public function search(
        array $params,
        ?string $formName = ''
    ): ?ActiveDataProvider {
        $this->load($params, $formName);
        if (!$this->validate()) {
            return null;
        }

        $class = get_parent_class();
        return new ActiveDataProvider([
            'query' => $class::find()
                ->joinWith('activeWorklog')
                ->andFilterWhere([
                    'created_by' => $this->created_by,
                    'activeWorklog.stage_id' => $this->activeStage,
                ])
        ]);
    }
}
