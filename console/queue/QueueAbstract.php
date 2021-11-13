<?php

namespace console\queue;

use yii\base\BaseObject;
use yii\helpers\Console;
use yii\queue\Queue;

abstract class QueueAbstract extends BaseObject implements \yii\queue\JobInterface
{
    abstract function run(Queue $queue);

    public function execute($queue)
    {
        try {
            $this->run($queue);
        } catch (\Exception $exception) {
            Console::output(__CLASS__ . ' : '. $exception->getMessage());
        }
    }
}