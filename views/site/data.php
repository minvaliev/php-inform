<?php 
use yii\helpers\Url;
?>

<div class="container">
    <h1>Личный кабинет</h1>
<?php
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin();?>

<?= $form->field($model,'surname')->textInput()?>

<?= $form->field($model,'name')->textInput()?>

<?= $form->field($model,'email')->textInput(['readonly'=> true])?>

<div>
    <button class="btn btn-success" type="submit">Сохранить</button>

    <!-- <a href="<?=Url::to(['site/delete', 'id'=>$model['id']])?>" class="btn btn-danger" type="button">Удалить профиль</a> -->
    <button id="btn-modal" class="btn btn-danger" type="button">Удалить профиль</button>    
    
</div>

<?php $form = ActiveForm::end();?>

<div id="modal-delete"class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Вы действительно хотите удалить профиль?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <a href="<?=Url::to(['site/delete', 'id'=>$model['id']])?>" class="btn btn-primary" type="button">Да</a>
        <!-- <button type="button" class="btn btn-danger">Да</button> -->
        <button type="button" class="btn btn-success" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>

</div>

