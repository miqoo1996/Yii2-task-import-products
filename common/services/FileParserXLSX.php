<?php

namespace common\services;

use common\exception\FileNotSupportedException;

/**
 * @package common\services
 */
class FileParserXLSX extends FileImportAdapter
{
    public function __construct($config = [])
    {
        parent::__construct($config);

        throw new FileNotSupportedException("XLSX import isn't implemented yet.");
    }

    public function toArray() : array
    {
        throw new FileNotSupportedException("XLSX import isn't implemented yet.");
    }

    public function getAttributes(): array
    {
        throw new FileNotSupportedException("XLSX import isn't implemented yet.");
    }

    public function parse(): void
    {
        throw new FileNotSupportedException("XLSX import isn't implemented yet.");
    }
}