<?php

namespace tsmd\oplog\models;

use Yii;

/**
 * This is the model class for table "{{%oplog}}".
 *
 * @property int $logid
 * @property int $operator
 * @property string $objid
 * @property string $route
 * @property string $method
 * @property string $ip
 * @property string $browser
 * @property string $platform
 * @property string $userAgent
 * @property string|null $header
 * @property string|null $query
 * @property string|null $body
 * @property int $createdTime
 */
class Oplog extends \tsmd\base\models\ArModel
{
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbLog');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oplog}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'logid'       => 'logid',
            'operator'    => 'Operator',
            'objid'       => 'Objid',
            'route'       => 'Route',
            'method'      => 'Method',
            'ip'          => 'IP',
            'browser'     => 'Browser',
            'platform'    => 'Platform',
            'userAgent'   => 'User Agent',
            'header'      => 'Header',
            'query'       => 'Query',
            'body'        => 'Body',
            'createdTime' => 'Created Time',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operator'], 'integer'],
            [['objid', 'route', 'method'], 'string', 'max' => 128],
            [['header', 'query', 'body'], 'safe'],
        ];
    }

    /**
     * @inheritDoc
     */
    protected function saveInput()
    {
        // 获取 udPlatform udBrowser IP
        $browser = get_browser(null, true);
        $this->browser = $browser['browser'];
        $this->platform = $browser['platform'];
        $this->ip = Yii::$app->request->getUserIP();
        $this->userAgent = Yii::$app->request->getUserAgent();

        if (empty($this->header)) {
            $header = Yii::$app->request->getHeaders();
            unset($header['Authorization'], $header['TSMD-Authorization']);
            $this->header = $header;
        }
        if (empty($this->query)) {
            $query = Yii::$app->request->getQueryParams();
            unset($query['access-token'], $query['accessToken']);
            $this->query = $query;
        }
        if (empty($this->body)) {
            $this->body = Yii::$app->request->getBodyParams();
        }
        if (is_array($this->header)) {
            $this->header = json_encode($this->header) ?: $this->header;
        }
        if (is_array($this->query)) {
            $this->query = json_encode($this->query) ?: $this->query;
        }
        if (is_array($this->body)) {
            $this->body = json_encode($this->body) ?: $this->body;
        }
        parent::saveInput();
    }

    /**
     * 查询后的格式化处理
     * @return $this
     */
    public function findFormat()
    {
        if (is_string($this->header)) {
            $this->header = $this->header ? json_decode($this->header, true) : [];
        }
        if (is_string($this->query)) {
            $this->query = $this->query ? json_decode($this->query, true) : [];
        }
        if (is_string($this->body)) {
            $this->body = $this->body ? json_decode($this->body, true) : [];
        }
        return $this;
    }

    /**
     * 格式化处理
     * @param array $row
     */
    public static function formatBy(array &$row)
    {
        if (is_string($row['header'])) {
            $row['header'] = $row['header'] ? json_decode($row['header'], true) : [];
        }
        if (is_string($row['query'])) {
            $row['query'] = $row['query'] ? json_decode($row['query'], true) : [];
        }
        if (is_string($row['body'])) {
            $row['body'] = $row['body'] ? json_decode($row['body'], true) : [];
        }
    }
}
