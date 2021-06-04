<?php

namespace roaresearch\yii2\workflow\roa\models;

use roaresearch\yii2\rmdb\SoftDeleteActiveQuery;
use roaresearch\yii2\roa\hal\{ARContract, ContractTrait};
use roaresearch\yii2\workflow\models as base;

/**
 * ROA contract to handle workflow stage records.
 */
class Stage extends base\Stage implements ARContract
{
    use ContractTrait {
        getLinks as getContractLinks;
    }

    /**
     * @inheritdoc
     */
    protected string $workflowClass = Workflow::class;

    /**
     * @inheritdoc
     */
    protected string $transitionClass = Transition::class;

    /**
     * @inheritdoc
     */
    protected function slugBehaviorConfig(): array
    {
        return [
            'resourceName' => 'stage',
            'parentSlugRelation' => 'workflow',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getContractLinks(), [
            'transitions' => $this->getSelfLink() . '/transition',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'workflow',
            'transitions',
            'detailTransitions',
            'totalTransitions',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWorkflow(): SoftDeleteActiveQuery
    {
        return parent::getWorkflow()->notDeleted();
    }
}
