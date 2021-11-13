<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\StoreProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'store_id')->widget(Select2::classname(), [
        'data' => $model->store_id ? [$model->store_id => $model->store->title] : [$model->getDropdownList()],
        'language' => 'en',
        'options' => [
            'value' => $model->store_id,
            'placeholder' => 'Select store ...',
            'id' => 'placement-id',
        ],
        'pluginOptions'=>[
            'minimumInputLength' => 1,
            'ajax'=>[
                'url' => Url::to(['store/list']),
                'dataType' => 'json',
            ]
        ],
    ])->label('Store'); ?>

    <?= $form->field($model, 'upc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
