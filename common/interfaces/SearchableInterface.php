<?php

namespace common\interfaces;

use yii\data\ActiveDataProvider;
use yii\db\Query;

interface SearchableInterface
{
    /**
     * @param Query $query
     * @throws \LogicException
     * @return void
     */
    public function generalSearch(Query $query) : void;

    /**
     * @param Query $query
     * @throws \LogicException
     * @return void
     */
    public function searchValidated(Query $query) : void;

    /**
     * @param array|null $params
     * @return ActiveDataProvider
     */
    public function search(?array $params = []) : ActiveDataProvider;
}