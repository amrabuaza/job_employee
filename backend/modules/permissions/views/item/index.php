<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\RouteRule;
use mdm\admin\components\Configs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = "Items";
$this->params['breadcrumbs'][] = $this->title;

$rules = array_keys(Configs::authManager()->getRules());
$rules = array_combine($rules, $rules);
unset($rules[RouteRule::RULE_NAME]);
?>
<div class="box box-primary">
    <div class="box-body table-responsive">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a("Create Item", ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
        <?=
        \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'label' => "Name",
                ],
                [
                    'attribute' => 'ruleName',
                    'label' => 'Rule Name',
                    'filter' => $rules
                ],
                [
                    'attribute' => 'description',
                    'label' => "Description",
                ],
                ['class' => 'yii\grid\ActionColumn',],
            ],
        ])
        ?>

    </div>
</div>