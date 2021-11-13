<?php

namespace common\interfaces;

use yii\data\ActiveDataProvider;

interface SearchModelInterface extends SearchableInterface
{
    /**
     * Ex. [[key => value, ...]]
     *
     * @return array
     */
    public function getDropdownList() : array;
}