<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\job\JobOffer */

$this->title = 'Create Job Offer';
$this->params['breadcrumbs'][] = ['label' => 'Job Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-offer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
