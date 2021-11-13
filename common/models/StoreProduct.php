<?php

namespace common\models;

use backend\models\ImportProductJob;
use common\interfaces\SearchableInterface;
use common\models\traits\SearchModel;
use Yii;
use yii\db\Query;
use yii\helpers\Console;

/**
 * This is the model class for table "{{%store_product}}".
 *
 * @property int $id
 * @property int|null $store_idpublic function behaviors()
{
    return [
        [
            'class' => TimestampBehavior::class,
            'createdAtAttribute' => 'create_time',
            'updatedAtAttribute' => 'update_time',
            'value' => new Expression('NOW()'),
        ],
    ];
}
 * @property string $upc
 * @property string $title
 * @property float|null $price
 *
 * @property Store $store
 */
class StoreProduct extends \yii\db\ActiveRecord  implements SearchableInterface
{
    use SearchModel;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%store_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id'], 'integer'],
            [['upc', 'title', 'price'], 'required'],
            [['price'], 'number'],
            [['upc'], 'string', 'max' => 32],
            [['title'], 'string', 'max' => 255],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
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
            'upc' => Yii::t('app', 'Upc'),
            'title' => Yii::t('app', 'Title'),
            'price' => Yii::t('app', 'Price'),
        ];
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
     * {@inheritdoc}
     * @return StoreProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StoreProductQuery(get_called_class());
    }

    /**
     * @param Query $query
     * @throws \LogicException
     * @return void
     */
    public function generalSearch(Query $query) : void
    {

    }

    /**
     *  Grid filtering conditions
     *
     * @param Query $query
     * @throws \LogicException
     * @return void
     */
    public function searchValidated(Query $query) : void
    {
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->title]);
    }

    /**
     * @param array $data
     * @param int|null $store_id
     * @return bool
     * @throws \yii\db\Exception
     */
    public function addMultipleProduct(array $data, ?int $store_id = null) : bool
    {
        if (empty($data)) return false;

        $transaction = \Yii::$app->db->beginTransaction();

        foreach ($data as $item) {
            $model = self::find()->filterUpc($item['upc'])->one() ?: clone $this;

            $model->setAttributes(array_merge($item, ['store_id' => $store_id ?: $this->store_id]));

            if (!$model->validate()) {
                Console::output("FAIL: FAILED INSERT " . json_encode($model->attributes));
                ImportProductJob::saveLog($store_id ?: $this->store_id, ImportProductJob::STATUS_FAIL, [
                    'message' => "FAIL: FAILED INSERT " . json_encode($model->attributes)
                ]);
               continue;
            }

            $model->save();
        }

        $transaction->commit();

        return true;
    }
}
