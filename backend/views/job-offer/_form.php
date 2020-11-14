<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\job\JobOffer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-offer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'job_id')->textInput() ?>

    <?= $form->field($model, 'employee_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
