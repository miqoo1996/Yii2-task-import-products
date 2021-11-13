<?php

namespace common\models\traits;

use common\interfaces\SearchableInterface;
use common\interfaces\SearchModelInterface;
use yii\data\ActiveDataProvider;

/**
 * @package common\models\traits
 *
 * @see symilar like Yii2.x SearchModel gii class
 * @see SearchableInterface, SearchModelInterface || required to implement those in models
 */
trait SearchModel
{
    protected string $dropdownListKey = 'id';
    protected string $dropdownListValue = 'title';

    protected array $searchDataProvider = [
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => [
            'defaultOrder' => [
                'title' => SORT_ASC,
            ]
        ],
    ];

    /**
     * Creates data provider instance with search query applied
     *
     * @param array|null $params
     *
     * @return ActiveDataProvider
     */
    public function search(?array $params = []) : ActiveDataProvider
    {
        $query = ($model = $this)->find();

        $dataProvider = new ActiveDataProvider(array_merge(['query' => $query], $this->searchDataProvider));

        $params = $params ?: $model->attributes;

        $this->generalSearch($query);

        if ($params && $model->load($params) && !$model->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->searchValidated($query);

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getDropdownList() : array
    {
        return array_map(fn($array) => [
            'id' => $array[$this->dropdownListKey],
            'text' => $array[$this->dropdownListValue]
        ], $this->search($this->attributes(), $this)->getModels());
    }
}