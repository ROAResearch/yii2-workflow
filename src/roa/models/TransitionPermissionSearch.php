<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\roa\hal\ARContractSearch;
use yii\{data\ActiveDataProvider, web\NotFoundHttpException};

/**
 * Contract to filter and sort collections of `TransitionPermission` records.
 *
 * @author Angel (Faryshta) Guevara <aguevara@alquimiadigital.mx>
 */
class TransitionPermissionSearch extends TransitionPermission implements
    ARContractSearch
{
    /**
     * @inhertidoc
     */
    public function rules()
    {
        return [
            [['created_by', 'source_stage_id', 'target_stage_id'], 'integer'],
            [['permission'], 'string'],
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
            null === $this->transition
            || $this->sourceStage->workflow_id != $params['workflow_id']
        ) {
            throw new NotFoundHttpException('Unexistant permission path.');
        }

        return new ActiveDataProvider([
            'query' => (get_parent_class())::find()->andFilterWhere([
                    'target_stage_id' => $this->target_stage_id,
                    'source_stage_id' => $this->source_stage_id,
                ])
                ->andFilterWhere(['like', 'permission', $this->permission]),
        ]);
    }
}
