<?php

namespace common\services;

/**
 * @package common\services
 */
class FileParserCSV extends FileImportAdapter
{
    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @var array
     */
    protected array $columns;

    /**
     * @return void
     */
    public function parse() : void
    {
        $this->attributes = array_map('str_getcsv', file($this->file));

        if (empty($this->attributes) || count($this->attributes) < 1) return;

        $this->columns = $this->attributes[0];
        array_shift($this->attributes);
    }

    /**
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $array = [];
        array_walk($this->attributes, function ($value, $key) use (&$array) {
            array_walk($this->columns, function ($name, $index) use (&$array, $value, $key) {
                if (in_array($name, $this->onlyAttributes)) {
                    if (empty($array[$key])) $array[$key] = [];
                    $array[$key][$name] = $this->attributes[$key][$index];
                }
            });
        });

        return $array;
    }
}