<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\roa\hal\{ARContract, ContractTrait};
use roaresearch\yii2\workflow\models as base;

/**
 * ROA contract to handle workflow transitions records.
 */
class Transition extends base\Transition implements ARContract
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
    protected string $permissionClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'resourceName' => 'transition',
            'parentSlugRelation' => 'sourceStage',
            'idAttributes' => ['target_stage_id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'permissions' => $this->getSelfLink() . '/permission',
            'target_stage' => $this->targetStage->getSelfLink(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return ['sourceStage', 'targetStage', 'permissions'];
    }
}
