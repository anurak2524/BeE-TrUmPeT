<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
//use miloschuman\highcharts\Highcharts;

$this->title = 'รายชื่อผู้ป่วย อันดับโรค OPD โรงพยาบาลเสริมงาม';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
function filter($col) {
    $filterresult = Yii::$app->request->getQueryParam('filterresult', '');
    if (strlen($filterresult) > 0) {
        if (strpos($col['result'], $filterresult) !== false) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}
$filteredData = array_filter($rawData, 'filter');
$searchModel = ['result' => Yii::$app->request->getQueryParam('$filterresult')];
$dataProvider = new ArrayDataProvider([
    'allModels' => $filteredData
        ]);
?>

<?php
$gridColumns=[
    ['class'=>'kartik\grid\SerialColumn'],    
    [
        'attribute'=>'vstdate',
        'label'=>'วันที่',
        'headerOptions'=>['class'=>'text-center'],
        'contentOptions'=>['class'=>'text-center']
    ],
    [
        'attribute'=>'hn',
        'label'=>'HN',
        'headerOptions'=>['class'=>'text-center']
    ],    
    [
        'attribute'=>'pname',
        'label'=>'คำนำหน้า',
        'headerOptions'=>['class'=>'text-center']
    ],
    [
        'attribute'=>'fname',
        'label'=>'ชื่อ',
        'headerOptions'=>['class'=>'text-center'],
        'contentOptions'=>['class'=>'text-center']
    ], 
    [
        'attribute'=>'lname',
        'label'=>'สกุล',
        'headerOptions'=>['class'=>'text-center']
    ],
    [
        'attribute'=>'pdx',
        'label'=>'โรค',
        'headerOptions'=>['class'=>'text-center'],
        'contentOptions'=>['class'=>'text-center']
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
        'type' => GridView::TYPE_INFO,
        'heading' => '<i class="fa fa-table" aria-hidden="true"></i> รายชื่อผู้ป่วย อันดับโรค OPD โรงพยาบาลเสริมงาม',
        'before'=>'<i class="fa fa-hand-o-right" aria-hidden="true"></i> โรค :: '.$rawData[0]['icdname'],
    ],
]);
?>