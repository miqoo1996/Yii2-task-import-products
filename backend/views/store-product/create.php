<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StoreProduct */

$this->title = Yii::t('app', 'Create Store Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Store Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
