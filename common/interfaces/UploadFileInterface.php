<?php

namespace common\interfaces;

interface UploadFileInterface
{
    /**
     * Will be used for changing column from "db column" to "uplodable column"
     * When upload is ready the file name is saved in DB's table.
     *
     *
     * ``` In View
     * <?= $form->field($model, '_file')->fileInput()->hint($model->file) ?>
     * <?= $form->field($model, '_image')->fileInput()->hint($model->image) ?>
     * ```
     *
     * ``` Usage
     *  class Model extends \yii\db\ActiveRecord implements UploadFileInterface
     * {
     *    use UploadFile;
     *
     *  public function rules() : array
     *  {
     *      return [
     *          ........
     *
     *          $this->getFileValidation('file')
     *          $this->getImageValidation('image')
     *
     *          ........
     *      ];
     *  }
     *
     *  public function getUploadableFields() : array
     *  {
     *      return [
     *          'db_column' => '_db_column'
     *          'file' => '_file'
     *          'image' => '_image'
     *      ]
     *  }
     * ```
     *
     * @return array
     */
    public function getUploadableFields(): array;
}