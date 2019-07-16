<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Registration;
use app\models\Login;
use app\models\Update;
use app\models\User;
use yii\helpers\Url;

class SiteController extends Controller
{
    public function actionLogout()
    {
        if(!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();
            return $this->redirect(['login']);
        }
    }

    public function actionIndex() {
        $model = new Registration();
        
    if(isset($_POST['Registration']))
        {
            // $model->attributes = Yii::$app->request->post('Registration');
            $model->surname = $_POST['Registration']['surname'];
            $model->name = $_POST['Registration']['name'];
            $model->email = $_POST['Registration']['email'];
            $model->password = $_POST['Registration']['password'];
            $model->password_repeat = $_POST['Registration']['password_repeat'];
            if($model->validate() && $model->registration())
            {
                // Yii::$app->session->setFlash('success', "Пользователь зарегистрирован");
                $email = $_POST['Registration']['email'];
                $sql = "SELECT * FROM USER WHERE email='$email'";
                $result = Yii::$app->db->createCommand($sql)->queryOne();
                $code = $result['activation'];
                $absoluteHomeUrl = Url::home(true);
                $url = $absoluteHomeUrl.'site/activation/'.$code;
                Yii::$app->mailer->compose('order-mail', ['activation' =>$url])
                        ->setFrom(['minvalievalbert@mail.ru' => 'Активация аккаунта'])
                        ->setTo($email)
                        ->setSubject('Для регистрации перейдите по ссылке')
                        ->send();
                return $this->render('confirm');
            }
            else {
                return $this->render('confirm');
            }
        }
        return $this->render('index',['model' => $model]);
    }

    public function actionActivation(){
        $login_model = new Login();
        $code = Yii::$app->request->get('code');
        //ищем код подтверждения в БД
        $find = User::find()->where(['activation'=>$code])->one();
        if($find){
            $find->status = 1;
            if ($find->save()) {
                $user = User::findOne(['activation'=>$find->activation]);
                Yii::$app->user->login($user);
                return $this->redirect(array('site/update','id'=>$find->id));
            }
        }
    $absoluteHomeUrl = Url::home(true);
    return $this->redirect($absoluteHomeUrl, 303); //на главную
}

    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $login_model = new Login();
        $model = new Update();
        $model_user = new User();
        if( Yii::$app->request->post('Login'))
        {
            $login_model->attributes = Yii::$app->request->post('Login');
            $email = $_POST['Login']['email'];
            $status = $model_user::find()->where(['email'=> $email])->all();
            if($login_model->validate() && $status['0']['status'] === 1)
            {
                Yii::$app->user->login($login_model->getUser());
                // return $this->goHome();
                $email = $_POST['Login']['email'];
                $sql = "SELECT * FROM USER WHERE email='$email'";
                $result = Yii::$app->db->createCommand($sql)->queryOne();
                $model->surname = $result['surname'];
                $model->name = $result['name'];
                $model->email = $result['email'];
                $id = $model->id = $result['id'];
                return $this->redirect(array('site/update','id'=>$id));
            }
            return $this->render('login',['login_model'=>$login_model]);
        }
        return $this->render('login',['login_model'=>$login_model]);
    }

    public function actionUpdate($id) {
        $model = new Update();
        $sql = "SELECT * FROM USER WHERE id='$id'";
        $result = Yii::$app->db->createCommand($sql)->queryOne();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model = User::find()->where(['id'=>$id])->one();
            $model->surname = $_POST['Update']['surname'];
            $model->name = $_POST['Update']['name'];
            if ($model->save()) {
            // return $this->render('data',['model'=>$model]);
            return $this->redirect(array('site/update','model'=>$model, 'id'=>$id));
            }
        }
        else {
            $model->surname =  $result['surname'];
            $model->name = $result['name'];
            $model->email = $result['email'];
            $model->id = $result['id'];
            return $this->render('data',['model'=>$model]);
        }
    }

    public function actionDelete($id) {
        Yii::$app->db->createCommand("DELETE FROM USER WHERE id='$id'")->execute();
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }
}
