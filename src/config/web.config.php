<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'base-app-web',
    'name' => "Base APP",
    'version' => '0.1',
    'basePath' => dirname(__DIR__),
    'class' => baseapi\web\Application::class,
    'bootstrap' => ['log'],
    'controllerNamespace' => 'baseapi\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
                // ...
            ],
        ],
        'request' => [
            'class' => baseapi\web\Request::class,
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'class' => yii\web\UrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'ruleConfig' => [
                'class' => yii\web\UrlRule::class
            ],
            'rules' => [
                '<controller>/create' => '<controller>/create',
                '<controller>/<id:\d+>/<action:(update|delete)>' => '<controller>/<action>',
                '<controller>/<id:\d+>' => '<controller>/view',
                '<controller>s' => '<controller>/index',
            ]
        ],
        'user' => [
            'identityClass' => baseapi\models\User::class,
            'enableSession' => true,
            'loginUrl' => ['access/login'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    'defaultRoute' => 'hello/index',
    'layout' => "main.twig",
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];

}

return $config;
