<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StoreProduct */

$this->title = Yii::t('app', 'Update Store Product: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Store Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="store-product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
