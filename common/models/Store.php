<?php

namespace common\models;

use common\interfaces\SearchModelInterface;
use common\models\traits\SearchModel;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%store}}".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property StoreProduct[] $storeProducts
 */
class Store extends \yii\db\ActiveRecord implements SearchModelInterface
{
    use SearchModel;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%store}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['id'], 'integer'],
            [['title'], 'string', 'min' => 1, 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * Gets query for [[StoreProducts]].
     *
     * @return \yii\db\ActiveQuery|StoreProductQuery
     */
    public function getStoreProducts()
    {
        return $this->hasMany(StoreProduct::className(), ['id' => 'store_id']);
    }

    /**
     * {@inheritdoc}
     * @return StoreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StoreQuery(get_called_class());
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
}
