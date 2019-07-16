
<div class="container">
    <h1>Регистрация</h1>

<?php if( Yii::$app->session->hasFlash('success') ): ?>
 <div class="alert alert-success alert-dismissible" role="alert">
 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 <?php echo Yii::$app->session->getFlash('success'); ?>
 </div>
<?php endif;?>

<?php
use \yii\widgets\ActiveForm;
?>
<?php
    $form = ActiveForm::begin([
        'class'=>'form-horizontal',
        ]);
?>

<?= $form->field($model,'surname')->textInput(['autofocus'=>true])->label('Фамилия') ?>

<?= $form->field($model,'name')->textInput()->label('Имя')?>

<?= $form->field($model,'email')->textInput()?>

<?= $form->field($model,'password')->passwordInput()->label('Пароль')?>

<?= $form->field($model,'password_repeat')->passwordInput()->label('Подтверждение пароля')?>

<div>

    <button type="submit" class="btn btn-primary">Зарегистрировать</button>
</div>

<?php
    ActiveForm::end();
?>
