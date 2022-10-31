<?php

namespace common\config\bootstrap;

use common\repositories\UserRepository;
use yii\base\BootstrapInterface;

/**
 * BoardBootstrap
 */
class UserBootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton('UserService');

        $container->set('common\repositories\UserInterface', function () {
            return new UserRepository();
        });
    }
}