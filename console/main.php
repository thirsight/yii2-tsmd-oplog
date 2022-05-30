<?php

/**
 * TSMD 模块配置文件
 *
 * @link https://tsmd.thirsight.com/
 * @copyright Copyright (c) 2008 thirsight
 * @license https://tsmd.thirsight.com/license/
 */

$dbTpl = require dirname(__DIR__) . '/../yii2-tsmd-base/config/_dbtpl-local.php';
return [
    // 设置路径别名，以便 Yii::autoload() 可自动加载 TSMD 自定的类
    'aliases' => [
        // yii2-tsmd-oplog 路径
        '@tsmd/oplog' => __DIR__ . '/../src',
    ],
    'components' => [
        'dbLog' => $dbTpl('tsmddb_log'),
    ],
    // 设置命令行模式控制器
    // ./yii migrate-oplog/create 'tsmd\oplog\migrations\M210221...'
    // ./yii migrate-oplog/new
    // ./yii migrate-oplog/up
    // ./yii migrate-oplog/down 1
    'controllerMap' => [
        'migrate-oplog' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'dbLog',
            'migrationPath' => [],
            'migrationNamespaces' => [
                'tsmd\oplog\migrations',
            ]
        ],
    ],
];
