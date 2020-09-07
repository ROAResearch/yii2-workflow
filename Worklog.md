Operating Worklog
=================

Each process can use a workflow to move between stages. Each movementis recorded
in a worklog record.

Each worklog must belong to a process through the field `proccess_id` and to an
stage trough the field `stage_id`.

Initial Worklog
---------------

Thee first worklog of each process is called 'initial worklog' and must belong
to an stage marked with the field `initial`.

By default the initial worklog is created at the same time as the paren process.
This means that when creating the process 2 aditional fields can be sent
`comment` and `stage_id` which will be stored in the worklog.

Active Worklog
--------------

The most recent worklog is called 'active worklog' it can be accesed using the
relation `Process::$activeWorkLog`.

That relation uses the strategy groupwise to determine the most recent worklog
associated to the process.

Process Flow
------------

The act of creating a new worklog for a process is called `flow` which depends
on the workflow associated to the process.

The `stage_id` in active worklog and the `stage_id` in the new worklog must be
linked in a `workflow transition` otherwise it will cause a validation error.

As such it also follows the other 2 rules of workflow transition which are that
the active user must have any of the permissions associated to the transition
in `workfloww transition permission`.

And if the process is asigned to a set of users only those user can make the
process flow.

The newly created worklog takes the place of the active worklog.

Queries Considerations
----------------------

The `Process::$worklogs` relation by default returns all the worklogs associated
to the process using an SQL join. As such it has a moderate impact in query
performance.

Contrary to that the `Process::$acctiveWorkLog` relation returns only the most
recent worklog and it requires an SQL join to access the worklogs and another
SQL join to apply the groupwise strategy. As such it has a bigger impact on the
query performance and must be used carefully.

The `Process::$acctiveWorkLog` relation utilizes 2 default table alias.

- activeWorklog: table alias to the worklog table containing the active worklog
- WorkLogGroupWise: table alias o the same worklog table filtering the most
  recent worklog.

Applying extra filters to each of this alias alters the nature of the query and
will produce different results.

Example: Lets assume the variable `$userId` stores the identifier of a user
and that the worklog table has a field `created_by` assoociating users.

Getting all the process that has been flown by `$userId`

```php
Process::find()
    ->innerJoinWith('workLogs')
    ->andWhere(['process_worklog.created_by' => $userId])
    ->all();
```

Getting all the process which active worklog was flown by `$userId`

```php
Process::find()
    ->innerJoinWith('activeWorkLog')
    ->andWhere(['activeWorkLog.created_by' => $userId])
    ->all();
```

Getting all the process which have been flown by `$userId` and load the most
recent flown by that user as `activeWorkLog`.

```php
Process::find()
    ->innerJoinWith('activeWorkLog')
    ->andWhere(['WorkLogGroupWise.created_by' => $userId])
    ->all();
```

Using the examples above its easy to write a query that brings all the process
with an active worklog on a certain stage ordered by the time they have been on
said stage.

```php
Process::find()
    ->innerJoinWith('activeWorkLog')
    ->andWhere(['activeWorklog.stage_id' => $stageId])
    ->orderBy(['activeWorkkLog.created_at' => 'asc'])
    ->all();
```

Resource considertions
----------------------

If you want to use worklogs with ROA resources there are a few things to be
careful.

- HAL links pointing to the workflow or the stage must link with the full route
  since the workflow or stage might belong to another ROA version.
- If an stage has no trasitions then trying to flow process from that stage will
  throw a BAD REQUEST HTTP STATUS (400}) not UNPROCESSABLE ENNTITY (422).
- Trying to flow a process assigned to someone else or without the proper
  permissions will thow a FORBIDDEN (403) HTTP STATUS
