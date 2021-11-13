<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Queues');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-queue-index">

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'channel',
            'job',
            'pushed_at',
            'ttr',
            //'delay',
            //'priority',
            'reserved_at',
            //'attempt',
            'done_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
