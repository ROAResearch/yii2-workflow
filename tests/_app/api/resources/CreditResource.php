<?php

namespace app\api\resources;

use app\api\models\{Credit, CreditSearch};
use roaresearch\yii2\roa\controllers\Resource;

/**
 * CRUD resource for `Credit` records
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class CreditResource extends Resource
{
    /**
     * @inheritdoc
     */
    public $modelClass = Credit::class;

    /**
     * @inheritdoc
     */
    public $searchClass = CreditSearch::class;
}
