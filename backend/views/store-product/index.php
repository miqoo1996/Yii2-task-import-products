<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StoreProduct */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Store Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-product-index">
    <?php if (Yii::$app->session->hasFlash('success-message')): ?>
        <p class="alert alert-success"><?= Yii::$app->session->getFlash('success-message') ?></p>
    <?php endif; ?>

    <div style="margin-bottom: 50px;display: flex;justify-content: space-between;align-items: center;flex-wrap: wrap;">
        <?= Html::a(Yii::t('app', 'Create Store Product'), ['create'], ['class' => 'btn btn-success']) ?>

        <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

        <div style="display: flex;flex-wrap: wrap;justify-content: space-around;gap: 10px;align-items: baseline;">
            <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

            <div style="display: flex;flex-wrap: wrap;justify-content: space-around;gap: 10px;align-items: baseline;">
                <?= $form->field($importForm, 'store_id')->widget(Select2::classname(), [
                    'language' => 'en',
                    'options' => [
                        'value' => $importForm->store_id,
                        'placeholder' => 'Select store ...',
                        'id' => 'store-placement-id',
                    ],
                    'pluginOptions'=>[
                        'minimumInputLength' => 1,
                        'ajax'=>[
                            'url' => Url::to(['store/list']),
                            'dataType' => 'json',
                        ]
                    ],
                ])->label(false); ?>

                <?= $form->field($importForm, '_file')->fileInput()->label(false) ?>

                <?= Html::submitButton(Yii::t('app', 'Upload Stores from CSV'), ['class' => 'btn btn-warning']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'id',
            'upc',
            'title',
            [
                'header' => 'Store Title',
                'attribute' => 'store.title',
                'format' => 'text',
            ],
            'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
