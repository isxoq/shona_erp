<?php

namespace common\models\behaviour;

use common\models\Queue;
use common\models\QueueState;

class QueueBehavior extends \yii\base\Behavior
{

    public function events()
    {
        return [
            Queue::EVENT_AFTER_INSERT => "afterInsert"
        ];
    }

    public function afterInsert()
    {

        $queueState = new QueueState([
            "queue_id" => $this->owner->id,
            "doctor_id" => $this->owner->doctor_id,
            "state" => QueueState::STATE_WAITING,
        ]);
        $queueState->save();

    }

}
