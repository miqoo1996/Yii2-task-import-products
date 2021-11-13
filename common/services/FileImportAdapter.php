<?php

namespace common\services;

use common\exception\FileNotSupportedException;

/**
 * @package common\services
 */
abstract class FileImportAdapter extends Service
{
    public const FILE_STORAGE = '@backend/web/uploads/';

    public const TYPE_CSV = 'CSV';

    /**
     * All supported files
     */
    public const SUPPORTED = [
        self::TYPE_CSV,
    ];

    /**
     * Those are the columns in the file we should be taking
     *
     * @var array|string[]
     */
    protected array $onlyAttributes = [
        'title', 'upc', 'price'
    ];

    /**
     * @var string
     */
    protected string $file;

    /**
     * @var array
     */
    protected array $data = [];

    public function __clone()
    {
        $this->file = null;
    }

    public function __isset($name)
    {
        return isset($this->toArray()[$name]);
    }

    abstract function toArray() : array;

    abstract function parse() : void;

    abstract function getAttributes() : array;

    /**
     * @return string
     */
    public static function getSupportedExts() : string
    {
        return strtolower(implode(',', self::SUPPORTED));
    }

    /**
     * @param string $file
     * @return $this
     */
    public function load(string $file): self
    {
        $this->file = \Yii::getAlias(self::FILE_STORAGE . $file);

        $this->parse();

        return $this;
    }

    /**
     * @param string $type
     * @param array $config
     * @throws FileNotSupportedException
     * @return self|FileParserCSV
     */
    public static function instance(string $type, array $config = []) : self
    {
        switch (strtoupper($type)) {
            case self::TYPE_CSV:
                return new FileParserCSV($config);
                break;
            default:
                throw new FileNotSupportedException(__CLASS__ . ':' . __FUNCTION__ . 'No exists in list - ' . self::getSupportedExts());
                break;
        }
    }
}