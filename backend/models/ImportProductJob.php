<?php

namespace backend\models;

use common\models\Store;
use common\models\StoreQuery;
use Yii;

/**
 * This is the model class for table "{{%import_product_job}}".
 *
 * @property int $id
 * @property int|null $store_id
 * @property string|null $status
 * @property string|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class ImportProductJob extends \yii\db\ActiveRecord
{
    public const STATUS_NEW = 'NEW';
    public const STATUS_PROCESSING = 'PROCESSING';
    public const STATUS_FAIL= 'FAIL';
    public const STATUS_DONE = 'DONE';
    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_PROCESSING,
        self::STATUS_FAIL,
        self::STATUS_DONE,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%import_product_job}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'created_at', 'updated_at'], 'integer'],
            [['data'], 'safe'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'store_id' => Yii::t('app', 'Store ID'),
            'status' => Yii::t('app', 'Status'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ImportProductJobQuery the active query used by this AR class.
     */
    public static function find() : ImportProductJobQuery
    {
        return new ImportProductJobQuery(get_called_class());
    }

    /**
     * Gets query for [[Store]].
     *
     * @return \yii\db\ActiveQuery|StoreQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }

    /**
     * @param int $store_id
     * @param string $status
     * @param array $data
     * @return static
     */
    public static function saveLog(int $store_id, string $status = self::STATUS_NEW, array $data = []) : self
    {
        $model = new self();

        $model->isNewRecord = true;

        $model->setAttributes([
            'store_id' => $store_id,
            'status' => $status,
            'data' => json_encode($data),
        ]);

        $model->save();

        return $model;
    }
}
