<?php

namespace app\api\resources;

use app\api\models\CreditWorkLog;
use roaresearch\yii2\roa\controllers\Resource;

/**
 * CRUD resource for `Credit Worklog` records
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class CreditWorkLogResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $createScenario = CreditWorkLog::SCENARIO_FLOW;

    /**
     * @inheritdoc
     */
    public $modelClass = CreditWorkLog::class;

    /**
     * @inheritdoc
     */
    public $filterParams = ['process_id'];
}
