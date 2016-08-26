<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\widgets\ActiveForm;

$this->title = '๑๐ อันดับโรค OPD โรงพยาบาลเสริมงาม';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['method' => 'get',
'action' => Url::to(['reports/opddiag']),]); ?>

<div class="well">
    ระหว่างวันที่:
        <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <?php
        echo yii\jui\DatePicker::widget([
            'name' => 'date1',
            'value' => $date1,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ],
            'options'=>[
                'class'=>'form-control'
            ],
        ]);
        ?>           
        ถึงวันที่:
        <?php
        echo yii\jui\DatePicker::widget([
            'name' => 'date2',
            'value' => $date2,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ],
            'options'=>[
                'class'=>'form-control'
            ],            
        ]);
        ?>
        </div>        
            
        <div class="col-xs-4 col-sm-4 col-md-2">
            <button class='btn btn-danger'>ประมวลผล</button>
        </div>    
         
</div>      
</div>

<?php ActiveForm::end();?>
<?php
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'attribute' => 'pdx',
        'label' => 'รหัสโรค',
        'headerOptions' => ['class' => 'text-center']
    ],
    [
        'attribute' => 'icdname',
        'label' => 'ชื่อโรค',
        'headerOptions' => ['class' => 'text-center']
    ],
    [
        'attribute' => 'a',
        'label' => 'จำนวน',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'value' => function($model)use($pdx,$date1,$date2) {
    return Html::a(Html::encode($model['a']), [
                'reports/indivopddiag',
                'pdx'=>$model['pdx'],
                'date1'=>$date1,
                'date2'=>$date2
                    ]
    );
}
    ],
];
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
    'columns' => $gridColumns,
    'responsive' => true,
    'hover' => true,
    'striped' => false,
    'floatHeader' => FALSE,
    //'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => '<i class="fa fa-caret-square-o-down" aria-hidden="true"></i> ๑๐ อันดับโรค OPD โรงพยาบาลเสริมงาม'
    ],
]);
?>

<?php
echo Highcharts::widget([
    'options' => [
        'credits' => ['enabled' => false],
        'title'=>['text'=>'๑๐ อันดับโรค OPD โรงพยาบาลเสริมงาม'],
        'xAxis' => [
            'categories' => $icdname
        ],
        'yAxis' => [
            'title' => ['text' => 'จำนวน(คน)']
        ],
        'series' => [
            [
                'type' => 'column',
                'name' => 'จำนวน',
                'data' => $a,
                'dataLabels' => [
                    'enabled' => true,
                ],
            ],
        ]
    ]
]);
?>
