<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\roa\ResourceSearch;
use yii\{data\ActiveDataProvider, NotFoundHttpException};

/**
 * Contract to filter and sort collections of `Transition` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class TransitionSearch extends Transition implements ResourceSearch
{

    /**
     * @inhertidoc
     */
    public function rules()
    {
        return [
            [['source_stage_id', 'created_by'], 'integer'],
            [['name'], 'string'],
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
        if (
            null === $this->sourceStage
            || $this->sourceStage->workflow_id != $params['workflow_id']
        ) {
            throw new NotFoundHttpException('Unexistant stage path.');
        }

        $class = get_parent_class();
        return new ActiveDataProvider([
            'query' => $class::find()->andFilterWhere([
                    'source_stage_id' => $this->source_stage_id,
                    'created_by' => $this->created_by,
                ])
                ->andFilterWhere(['like', 'name', $this->name]),
        ]);
    }
}
