
<div class="container">

<h1>Логин</h1>
<?php
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin();?>

<?= $form->field($login_model,'email')->textInput()?>

<?= $form->field($login_model,'password')->passwordInput()?>

<div>
    <button class="btn btn-success" type="submit">Войти</button>
</div>

<?php $form = ActiveForm::end();?>

</div>  


