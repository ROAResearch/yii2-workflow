<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\roa\hal\{Contract, ContractTrait};
use roaresearch\yii2\workflow\models as base;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle workflow records.
 */
class Workflow extends base\Workflow implements Contract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }

    /**
     * @inheritdoc
     */
    protected $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'resourceName' => 'workflow',
            'checkAccess' => function ($params) {
                if (
                    isset($params['workflow_id'])
                    && $this->id != $params['workflow_id']
                ) {
                    throw new NotFoundHttpException(
                        'Workflow not associated to element.'
                    );
                }
            },
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'stages' => $this->getSelfLink() . '/stage',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['stages', 'detailStages', 'totalStages'];
    }
}
