<?php 
namespace app\models;

use yii\base\Model;
use Yii;

class Registration extends Model {
    public $surname;
    public $name;
    public $email;
    public $password;
    public $password_repeat;
    public $activation;
    public function rules()
    {
        return [
            [['email','name','surname'],'required'],
            ['email','email'],
            ['email', 'unique',
            'targetClass' => User::className(),
            'message' => 'Эта почта уже занята.'],
            // ['password','string','min'=>2,'max'=>10],
            ['password', 'required'],
            ['password', 'string', 'min' => 1],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password',  'message'=>"Пароли не совпадают!" ],
        ];
    }

    public function Registration()
    {
        $user = new User();
        $user->surname = $this->surname;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        // $user->password = sha1($this->password);
        $user->setPasswordRepeat($this->password_repeat);
        // $user->password_repeat = sha1($this->password_repeat);
        $user->activation = md5($user->email.time()); 
        return $user->save(); //вернет true или false
    }

    public $myAttributeLabels = [];

    public function attributeLabels()
 {
    return [
    'name'=>Yii::t('app','Имя'), 
    'surname'=>Yii::t('app','Фамилия'), 
    'password'=>Yii::t('app','Пароль'), 
    'password_repeat'=>Yii::t('app','Подтверждение'), 
    ];
 }

}