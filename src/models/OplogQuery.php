<?php

namespace tsmd\oplog\models;

use tsmd\base\models\TsmdQueryTrait;

/**
 * This is the Query class for [[Oplog]].
 */
class OplogQuery extends \yii\db\Query
{
    use TsmdQueryTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->from(Oplog::tableName());
        $this->modelClass = Oplog::class;
    }

    /**
     * @return array
     */
    public function allWithFormat()
    {
        $rows = $this->all();
        array_walk($rows, function (&$r) {
            Oplog::formatBy($r);
        });
        return $rows;
    }
}
