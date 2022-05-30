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
    'components' => [
        'dbLog' => $dbTpl('tsmddb_log'),
    ],
];
