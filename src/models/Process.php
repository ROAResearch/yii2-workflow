<?php

namespace roaresearch\yii2\workflow\models;

use roaresearch\yii2\rmdb\models\Entity;
use yii\{base\InvalidConfigException, db\ActiveQuery};

/**
 * Model class for process which change stages depending on a worklow
 *
 * @property int workflowId
 * @property Workflow workflow
 * @property WorkLog[] $workLogs
 * @property WorkLog $activeWorkLog
 */
abstract class Process extends Entity
{
    /**
     * @var WorkLog model used internally to create the initial WorkLog
     * @see hasInitialWorkLog()
     */
    private $initialWorkLog;

    /**
     * @var bool Whether or not autogenerate the initial worklog. It only works
     * on new records.
     * @see hasInitialWorkLog()
     */
    protected $autogenerateInitialWorklog = true;

    /**
     * @return string full class name of the class to be used for the relation
     * `getWorkflow()`.
     */
    public function workflowClass(): string
    {
        return Workflow::class;
    }

    /**
     * @return string full class name of the class to be used to store the
     * assignment records.
     */
    abstract protected function assignmentClass(): string;

    /**
     * @return string full class name of the class to be used to store the
     * WorkLog records.
     */
    abstract protected function workLogClass(): string;

    /**
     * @return int the id of the workflow this process belongs to.
     */
    abstract public function getWorkflowId(): int;

    /**
     * Determines if the current process record has the need of an initial
     * worklog. If thats the case it autogenerates the initial worklog in case
     * its not already autogenerated.
     *
     * @return bool whether the initial worklog was autogenerated.
     */
    private function hasInitialWorkLog(): bool
    {
        if (!$this->autogenerateInitialWorklog || !$this->isNewRecord) {
            return false;
        }
        if (null === $this->initialWorkLog) {
            $this->initialWorkLog = $this->ensureWorkLog([
                'scenario' => WorkLog::SCENARIO_INITIAL,
            ]);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        if ($this->hasInitialWorklog()) {
            $logLoad = $this->initialWorkLog->load($data, $formName);

            return parent::load($data, $formName) || $logLoad;
        }

        return parent::load($data, $formName);
    }

    /**
     * Whether the user is asigned to the process.
     *
     * @param ?int $userId
     * @return bool
     */
    public function userAssigned(?int $userId): bool
    {
        return !$this->getAssignments()->exists() // no one is assigned
            || $this->getAssignments()
                ->andWhere(['user_id' => $userId])
                ->exists();
    }

    /**
     * @inheritdoc
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        $parentValidate = parent::validate($attributeNames, $clearErrors);
        if ($this->hasInitialWorklog()) {
            if (
                $this->initialWorkLog->validate($attributeNames, $clearErrors)
            ) {
                return $parentValidate;
            }

            $this->addErrors($this->initialWorkLog->getErrors());

            return false;
        }

        return $parentValidate;
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT,
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->initialWorkLog->process_id = $this->id;
            $this->initialWorkLog->save(false); // skip validation
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!is_subclass_of($this->workLogClass(), WorkLog::class)) {
            throw new InvalidConfigException(
                static::class . '::workLogClass() must extend '
                    . WorkLog::class
            );
        }
        if (!is_subclass_of($this->assignmentClass(), Assignment::class)) {
            throw new InvalidConfigException(
                static::class . '::assignmentClass() must extend '
                    . Assignment::class
            );
        }
        parent::init();
    }

    /**
     * @return Workflow
     */
    public function getWorkflow(): Workflow
    {
        $workflowClass = $this->workflowClass();

        return $workflowClass::findOne($this->getWorkflowId());
    }

    /**
     * @return ActiveQuery
     */
    public function getAssignments(): ActiveQuery
    {
        return $this->hasMany($this->assignmentClass(), [
            'process_id' => 'id',
        ])->inverseOf('process');
    }

    /**
     * @return ActiveQuery
     */
    public function getWorkLogs(): ActiveQuery
    {
        return $this->hasMany($this->workLogClass(), [
            'process_id' => 'id',
        ])->inverseOf('process');
    }

    /**
     * @return ActiveQuery
     * @see https://dev.mysql.com/doc/refman/5.7/en/example-maximum-column-group-row.html
     */
    public function getActiveWorkLog(): ActiveQuery
    {
        $query = $this->getWorkLogs()->alias('WorkLog');
        $query->multiple = false;
        $workLogClass = $this->workLogClass();

        return $query->andWhere([
            'Worklog.id' => $workLogClass::find()
                ->alias('WorkLog_groupwise')
                ->select(['MAX(Worklog_groupwise.id)'])
                ->andWhere('WorkLog.process_id = WorkLog_groupwise.process_id')
        ]);
    }

    /**
     * Adds record to the WorkLog effectively transitioning the stage of the
     * process.
     *
     * @param array|WorkLog the WorkLog the process will transit to or an array
     * to create said WorkLog.
     * @param bool $runValidation
     */
    public function flow(&$workLog, bool $runValidation = true)
    {
        $workLog = $this->ensureWorkLog($workLog);
        $workLog->scenario = WorkLog::SCENARIO_FLOW;

        return $workLog->save($runValidation);
    }

    /**
     * Ensures that the provided parameter is either an array to create a valid
     * instance of the `workLogClass()` class.
     *
     * @param array|WorkLog $workLog
     * @return WorkLog extending the class defined in `workLogClass()`
     */
    private function ensureWorkLog($workLog): WorkLog
    {
        $workLogClass = $this->workLogClass();
        if (is_array($workLog)) {
            $workLog = new $workLogClass($workLog);
        } elseif (!$workLog instanceof $workLogClass) {
            throw new InvalidParamException(
                "Parameter must be an instance of {$workLogClass} or an "
                    . 'array to configure an instance'
            );
        }

        $workLog->process_id = $this->id;
        $workLog->populateRelation('process', $this);

        return $workLog;
    }
}
