<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\roa\hal\ARContractSearch;
use yii\data\ActiveDataProvider;

/**
 * Contract to filter and sort collections of `Workflow` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class WorkflowSearch extends Workflow implements ARContractSearch
{
    /**
     * @inhertidoc
     */
    public function rules()
    {
        return [
            [['created_by'], 'integer'],
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

        return $this->validate()
            ? new ActiveDataProvider([
                'query' => (get_parent_class())::find()->andFilterWhere([
                        'created_by' => $this->created_by,
                    ])
                    ->andFilterWhere(['like', 'name', $this->name])
                    ->notDeleted(),
            ])
            : null;
    }
}
