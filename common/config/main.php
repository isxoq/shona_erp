<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'gii',
        'common\config\bootstrap\QueueBootstrap',
    ],
    'language' => 'uz',
    'timeZone' => 'Asia/Tashkent',
    'name' => 'Beginner Advanced app',
    'components' => [
        'firebase' => [
            'class' => 'common\components\Firebase',
            'database' => "https://tashxis-online-default-rtdb.firebaseio.com",
            'auth_key' => "EIqxcg5x8BXNYeYj15XJhN9H1r6P31G7KHgmA00X"
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'i18n' => [
            'translations' => [
                'site*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@soft/i18n/messages',
                    'fileMap' => [
                        'site' => 'site.php',
                    ],
                ],
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],
        'view' => [
            'class' => 'soft\web\View',
        ],
        'formatter' => [
            'class' => 'soft\i18n\Formatter',
        ],
        'htmlToDoc' => [
            'class' => 'common\components\HtmlToDoc',
        ]
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'softModel' => [
                    'class' => 'soft\gii\generators\model\Generator',
                ],
                'softAjaxCrud' => [
                    'class' => 'soft\gii\generators\crud\Generator',
                ],
            ]
        ]
    ]
];
