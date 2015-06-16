<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div style="width: 1000px; height: 75px;">
        <div style="float: left; width: 100px; height: 75px;">
            <?= $form->field($model, 'name') ?>
        </div>
        <div style="float: left; width: 100px; height: 75px; margin-left: 15px;">
            <?php echo $form->field($model, 'author_id')->dropDownList($authors) ?>
        </div>
        <div style="overflow: hidden"></div>
    </div>

    <div style="width: 1000px; height: 75px;">
        <div style="float: left; width: 100px; height: 75px;">
            <?php echo $form->field($model, 'date_from') ?>
        </div>
        <div style="float: left; width: 100px; height: 75px; margin-left: 15px;">
            <?php echo $form->field($model, 'date_to') ?>
        </div>
        <div class="form-group" style="float:right; width: 150px; height: 50px;">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>
        <div style="overflow: hidden"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
