<?php

/**
 * TSMD 模块配置文件
 *
 * @link https://tsmd.thirsight.com/
 * @copyright Copyright (c) 2008 thirsight
 * @license https://tsmd.thirsight.com/license/
 */

$dbTpl = require dirname(__DIR__) . '/../yii2-tsmd-base/config/_dbtpl.php';
return [
    // 设置路径别名，以便 Yii::autoload() 可自动加载 TSMD 自定的类
    'aliases' => [
        // yii2-tsmd-oplog 路径
        '@tsmd/oplog' => __DIR__ . '/../src',
    ],

    // 模块配置
    'modules' => [
        'oplog' => [
            'class' => 'tsmd\oplog\Module',
        ],
    ],

    // 组件配置
    'components' => [
        'dbLog' => $dbTpl('tsmddb_log'),
    ]
];
