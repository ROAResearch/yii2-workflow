<?php

$now = new \yii\db\Expression('NOW()');

return [
    [
        'process_id' => 1,
        'stage_id' => 4,
        'commentary' => 'Initial Stage Workflow 1',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 4,
        'stage_id' => 4,
        'commentary' => 'Initial Stage Workflow 2',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 4,
        'stage_id' => 5,
        'commentary' => 'Stage 4 to Stage 5',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 4,
        'stage_id' => 6,
        'commentary' => 'Stage 5 to Stage 6',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 4,
        'stage_id' => 7,
        'commentary' => 'Stage 6 to Stage 7',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 2,
        'stage_id' => 1,
        'commentary' => 'Initial Stage Workflow 1',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 3,
        'stage_id' => 1,
        'commentary' => 'Initial Stage Workflow 1',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 5,
        'stage_id' => 1,
        'commentary' => 'Initial Stage Workflow 1',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 6,
        'stage_id' => 1,
        'commentary' => 'Initial Stage Workflow 1',
        'created_by' => 1,
        'created_at' => $now,
    ],
    [
        'process_id' => 7,
        'stage_id' => 1,
        'commentary' => 'Initial Stage Workflow 1',
        'created_by' => 1,
        'created_at' => $now,
    ],
];
