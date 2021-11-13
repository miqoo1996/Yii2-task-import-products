<?php

namespace common\models\traits;

use yii\base\UnknownPropertyException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Trait UploadFile
 * @property string $destinationFiles
 * @property array $deletableFiles
 * @package common\models\traits
 */
trait UploadFile
{
    public $destinationFiles = '@backend/web/uploads/';

    protected $deletableFiles = [];

    public function __set($name, $value)
    {
        try {
            parent::__set($name, $value);
        } catch (UnknownPropertyException $exception) {
            if (substr($name, 0, 1) === '-') {
                throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
            }
        }

        $this->$name = $value;
    }

    public function __get($name)
    {
        try {
            $attribute = parent::__get($name);
            return $attribute;
        } catch (UnknownPropertyException $exception) {
            $attribute = $this->getUploadableFields()[$name] ?? null;
        }

        if (!$attribute && substr($name, 0, 1) === '-') {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
        }

        return $attribute;
    }

    public function getFileValidation(string $name, array $rules = [], ?bool $skipOnEmpty = null)
    {
        return array_merge([
            $this->getUploadableFields()[$name],
            'file',
            'skipOnEmpty' => !is_null($skipOnEmpty) ? $skipOnEmpty : !$this->isNewRecord
        ], $rules);
    }

    /**
     * ```
     * [
     *  'minWidth' => 250,
     *  'minHeight' => 250,
     *  'maxWidth' => 2500,
     *  'maxHeight' => 2500,
     *  'extensions' => 'svg, jpeg, jpg, gif, png',
     *  'maxSize' => 1024 * 1024 * 20,
     * ]
     * ```
     */
    public function getImageValidation(string $name, array $rules = [], ?bool $skipOnEmpty = null)
    {
        return array_merge([
            $this->getUploadableFields()[$name],
            'image',
            'extensions' => 'svg, jpeg, jpg, gif, png',
            'maxSize' => 1024 * 1024 * 20,
            'skipOnEmpty' => !is_null($skipOnEmpty) ? $skipOnEmpty : !$this->isNewRecord
        ], $rules);
    }

    public function beforeValidate()
    {
        foreach ($this->getUploadableFields() as $dbColumn => $field) {
            $this->deletableFiles[$dbColumn] = $this->$dbColumn;
            $this->$field = UploadedFile::getInstance($this, $field);
        }

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        foreach ($this->getUploadableFields() as $field) {
            $this->upload($field, $this->destinationFiles);
        }

        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        foreach ($this->getUploadableFields() as $dbColumn => $field) {
            $this->deleteFile($dbColumn, $this->destinationFiles);
        }

        return parent::beforeDelete();
    }

    public function deleteFile($column, $destination)
    {
        $file = \Yii::getAlias($destination . $this->$column);

        if (is_file($file)) {
            unlink($file);
        }
    }

    public function proceedDeletable($file, $destination)
    {
        $file = \Yii::getAlias($destination . $file);

        if (is_file($file)) {
            unlink($file);
        }
    }

    public function deleteDir($destination = null)
    {
        try {
            FileHelper::removeDirectory(
                \Yii::getAlias($destination ?: $this->destinationFiles)
            );

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function fileMove($column, $name = null, $destination = null)
    {
        if (substr($column, 0, 1) != '_') {
            $column = "_$column";
        }

        $destination = $destination ?: $this->destinationFiles;

        if (!is_dir(\Yii::getAlias($destination))) {
            mkdir(\Yii::getAlias($destination));
        }

        $this->$column = UploadedFile::getInstance($this, $column);

        if ($this->$column) {
            $file = ($name ?: $this->$column->baseName . uniqid()) . '.' . $this->$column->extension;
            $this->$column->saveAs($destination . $file);
        }

        return true;
    }

    public function upload($column, $destination = null, $deleteOld = true)
    {
        if (substr($column, 0, 1) != '_') {
            $column = "_$column";
        }

        $destination = $destination ?: $this->destinationFiles;

        if (!is_dir(\Yii::getAlias($destination))) {
            mkdir(\Yii::getAlias($destination));
        }

        $this->$column = UploadedFile::getInstance($this, $column);
        $dbColumn = array_search($column, $this->getUploadableFields());

        if ($this->$column) {
            if ($deleteOld === true) {
                $this->proceedDeletable($this->$dbColumn, $destination);
            }

            $this->$dbColumn = $this->$column->baseName . uniqid() . '.' . $this->$column->extension;
            $this->$column->saveAs($destination . $this->$dbColumn);
        } elseif (isset($this->deletableFiles[$dbColumn])) {
            $this->$dbColumn = $this->deletableFiles[$dbColumn];
        }
    }
}