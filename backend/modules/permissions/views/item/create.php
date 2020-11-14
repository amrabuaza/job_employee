<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$context = $this->context;
$labels = $context->labels();
$this->title = "Create Item";
$this->params['breadcrumbs'][] = ['label' => "Items", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-body table-responsive">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>
    </div>

</div>
