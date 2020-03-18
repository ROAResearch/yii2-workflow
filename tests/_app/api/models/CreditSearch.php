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
            [['created_by'], 'integer'],
            [
                ['activeStage'],
                'each',
                'allowMessageFromRule' => true,
                'rule' => [
                    'integer',
                    'message' => '{value} is not an integer',
                ],
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
                ->joinWith('activeWorkLog')
                ->andFilterWhere([
                    'credit.created_by' => $this->created_by,
                    'activeWorkLog.stage_id' => $this->activeStage,
                ])
        ]);
    }
}
