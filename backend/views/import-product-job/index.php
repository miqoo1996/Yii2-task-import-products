<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Import Product Jobs Status');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-product-job-index">

    <div style="margin-bottom: 50px;">
        <?= Html::a(Yii::t('app', 'Back to Products page'), ['store-product/index'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php if (Yii::$app->session->hasFlash('success-message')): ?>
        <p class="alert alert-success"><?= Yii::$app->session->getFlash('success-message') ?></p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'store.title',
            'status',
            'data',
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
