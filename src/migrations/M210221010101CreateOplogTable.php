<?php

namespace tsmd\oplog\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%oplog}}`.
 */
class M210221010101CreateOplogTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%oplog}}';
        $sql = <<<SQL
CREATE TABLE {$table} (
    `logid`     int(11) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `operator`  int(11) UNSIGNED NOT NULL DEFAULT 0,
    `objid`     VARCHAR(64) NOT NULL DEFAULT '',
    `route`     VARCHAR(128) NOT NULL DEFAULT '',
    `method`    VARCHAR(128) NOT NULL DEFAULT '',
    `ip`        VARCHAR(64) NOT NULL,
    `browser`   VARCHAR(32) NOT NULL,
    `platform`  VARCHAR(32) NOT NULL,
    `userAgent` VARCHAR(255) NOT NULL,
    `header`    TEXT,
    `query`     TEXT,
    `body`      TEXT,
    `createdTime` INT(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE {$table}
  ADD KEY `operator` (`operator`),
  ADD KEY `objid` (`objid`),
  ADD KEY `createdTime` (`createdTime`);

ALTER TABLE {$table} AUTO_INCREMENT = 1000001;
SQL;
        $this->getDb()->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%oplog}}');
    }
}
