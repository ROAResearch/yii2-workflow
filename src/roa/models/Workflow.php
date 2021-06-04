<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\rmdb\SoftDeleteActiveQuery;
use roaresearch\yii2\roa\{behaviors\Slug, hal\ARContract, hal\ContractTrait};
use roaresearch\yii2\workflow\models as base;
use yii\{base\Action, web\NotFoundHttpException};

/**
 * ROA contract to handle workflow records.
 */
class Workflow extends base\Workflow implements ARContract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }

    /**
     * @inheritdoc
     */
    protected string $stageClass = Stage::class;

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): Slug
    {
        return new class (['owner' => $this]) extends Slug {
            public string $resourceName = 'workflow';

            public function checkAccess(
                array $params = [],
                ?Action $action = null
            ): void {
                if (
                    isset($params['workflow_id'])
                    && $this->owner->id != $params['workflow_id']
                ) {
                    throw new NotFoundHttpException(
                        'Workflow not associated to element.'
                    );
                }
            }
        };
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

    /**
     * @inheritdoc
     */
    public function getStages(): SoftDeleteActiveQuery
    {
        return parent::getStages()->notDeleted();
    }
}
