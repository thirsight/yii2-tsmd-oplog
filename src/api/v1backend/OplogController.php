<?php

namespace tsmd\oplog\api\v1backend;

use tsmd\base\models\TsmdResult;
use tsmd\oplog\models\Oplog;
use tsmd\oplog\models\OplogQuery;

/**
 * OplogController implements the CRUD actions for Oplog model.
 */
class OplogController extends \tsmd\base\controllers\RestBackendController
{
    /**
     * 日志列表
     *
     * <kbd>API</kbd> <kbd>GET</kbd> <kbd>AUTH</kbd> `/oplog/v1backend/oplog/search`
     *
     * Argument | Type | Required | Description
     * -------- | ---- | -------- | -----------
     * operator | [[integer]] | No | operator
     * objid    | [[string]]  | No | objid
     *
     * @return array
     */
    public function actionSearch()
    {
        $query = new OplogQuery();
        $query->andFilterWhere(['operator' => $this->getBodyParams('operator')]);
        $query->andFilterWhere(['objid' => $this->getBodyParams('objid')]);

        $count = $query->count();
        $rows  = $query->addPaging()->orderBy('logid DESC')->allWithFormat();
        return TsmdResult::response($rows, ['count' => $count]);
    }

    /**
     * 查看日志
     *
     * <kbd>API</kbd> <kbd>POST</kbd> <kbd>AUTH</kbd> `/oplog/v1backend/oplog/view`
     *
     * Argument | Type | Required | Description
     * -------- | ---- | -------- | -----------
     * logid    | [[integer]] | Yes | Log ID
     *
     * @return array
     */
    public function actionView($logid)
    {
        return TsmdResult::responseModel($this->findModel($logid)->findFormat()->toArray());
    }

    /**
     * @param string $logid
     * @return Oplog the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $logid)
    {
        if (($model = Oplog::findOne(['logid' => $logid])) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('The requested `oplog` does not exist.');
        }
    }
}
