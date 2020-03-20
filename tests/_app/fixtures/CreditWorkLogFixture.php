<?php

namespace app\fixtures;

use app\models\CreditWorkLog;
use yii\test\ActiveFixture;

/**
 * Fixture to load default credit.
 *
 * @author Carlos (neverabe) Llamosas <carlos@invernaderolabs.com>
 */
class CreditWorkLogFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = CreditWorkLog::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/credit_worklog.php';

    /**
     * @inheritdoc
     */
    public $depends = ['app\fixtures\CreditFixture'];
}
