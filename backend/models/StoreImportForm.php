<?php

namespace backend\models;

use common\interfaces\UploadFileInterface;
use common\models\Store;
use common\services\FileImportAdapter;
use yii\base\Model;
use common\models\traits\UploadFile;

/**
 * StoreImportForm
 */
class StoreImportForm extends Model implements UploadFileInterface
{
    use UploadFile;

    public const MAX_SIZE = 1024 * 1024 * 5; // 5mb

    public $file;

    public $store_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id'], 'required'],
            [['store_id'], 'integer'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::className(), 'targetAttribute' => ['store_id' => 'id']],
            $this->getFileValidation('file', [
                'extensions' => FileImportAdapter::getSupportedExts(),
                'maxSize' => self::MAX_SIZE,
                'checkExtensionByMimeType' => false
            ], false),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'File' => 'Import File',
        ];
    }

    /**
     * {@inheritdoc}
     * @return string[]
     */
    public function getUploadableFields(): array
    {
        return [
            'file' => '_file'
        ];
    }
}
