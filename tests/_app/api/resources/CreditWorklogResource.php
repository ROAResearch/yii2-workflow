<?php

namespace app\api\resources;

use app\api\models\CreditWorklog;
use roaresearch\yii2\roa\controllers\Resource;

/**
 * CRUD resource for `Credit Worklog` records
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class CreditWorklogResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $createScenario = CreditWorklog::SCENARIO_FLOW;

    /**
     * @inheritdoc
     */
    public $modelClass = CreditWorklog::class;

    /**
     * @inheritdoc
     */
    public $filterParams = ['process_id'];
}
