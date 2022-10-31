<?php

namespace common\config\bootstrap;

use common\repositories\QueueRepository;
use yii;
use yii\base\BootstrapInterface;
use yii\di\Container;

/**
 * BoardBootstrap
 */
class QueueBootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton('QueueService');

        $container->set('common\repositories\QueueInterface', function () {
            return new QueueRepository();
        });
    }
}