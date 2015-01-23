<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ParseForm */

$this->title = 'Link parsing';
?>
<div class="site-parser">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Заполните поля для авторизации:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'parse-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'url') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Спарсить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if(isset($hrefs)){
        echo '<ul>';
        foreach($hrefs as $href){
            echo '<li>'.$href."</li>";
        }
        echo '</ul>';
    }
    ?>

</div>