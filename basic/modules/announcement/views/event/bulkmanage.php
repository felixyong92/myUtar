<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\announcement\models\Event;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\announcement\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bulk Manage Event';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-bulkmanage">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $status_array = [
        0 => 'Active',
        1 => 'Archived'
    ];
   ?>

   <?=Html::beginForm(['event/bulk'],'post');?>
   <?=Html::dropDownList('action','',[''=>'Choose an action: ','d'=>'Delete','a'=>'Archive', 'b'=>'Backup'],['class'=>'dropdown',])?>
   <?=Html::submitButton('Apply', ['class' => 'btn btn-info',]);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'publishDate',
            'startDate',
            'search date'=>'endDate',
            ['label' => 'Status',
           'value' => function($model){
               return $model->statusText;},
           'attribute' => 'status',
           'filter' =>  $status_array,
           ],
            [
                'attribute'=>'dId',
                'filter'=> Yii::$app->user->identity->dsResponsibility == 'Super Admin' ? ArrayHelper::map(Event::find()->all(), 'dId', 'dId') : ''
            ],
            ['class' => 'yii\grid\ActionColumn',
          'template'=> '{view}',
        ],
            ['class' => 'yii\grid\CheckboxColumn',
          ],
        ],
    ]); ?>
    <?= Html::endForm();?>
</div>
