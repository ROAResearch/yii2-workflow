<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\roa\ResourceSearch;
use yii\{data\ActiveDataProvider, web\NotFoundHttpException};

/**
 * Contract to filter and sort collections of `Stage` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class StageSearch extends Stage implements \roaresearch\yii2\roa\ResourceSearch
{
    /**
     * @inhertidoc
     */
    public function rules()
    {
        return [
            [['workflow_id', 'created_by'], 'integer'],
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

        if (null === $this->workflow) {
            throw new NotFoundHttpException('Unexistant workflow path.');
        }

        $class = get_parent_class();
        return new ActiveDataProvider([
            'query' => $class::find()->andFilterWhere([
                    'created_by' => $this->created_by,
                    'workflow_id' => $this->workflow_id,
                ])
                ->andFilterWhere(['like', 'name', $this->name])
                ->notDeleted(),
        ]);
    }
}
