<?php 
namespace app\models;

use yii\base\Model;

class Update extends Model {
    public $id;
    public $surname;
    public $name;
    public $email;
    public $password;
    public $password_repeat;
    public function rules()
    {
        return [
            [['name','surname'],'required'],
            // ['email','email'],
            // ['email','unique','targetClass'=>'app\models\User'],
            // ['password','string','min'=>2,'max'=>10],
            // ['password', 'required'],
            // ['password', 'string', 'min' => 1],
            // ['password_repeat', 'required'],
            // ['password_repeat', 'compare', 'compareAttribute'=>'password',  'message'=>"Passwords don't match" ],
        ];
    }
}