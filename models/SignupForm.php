<?php
namespace app\models;

use yii\base\Model;
use Yii;
use yii\web\Session;
use yii\swiftmailer;
/**
 * Signup form
 */
class SignupForm extends Model
{
    //public $username;
    public $email;
    public $password;
    public $repeatpassword;
    //public $verifyCode;
    public $name;
    //public $last_name;
    //public $phone;
    public $rules;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => "Це ім'я користувача вже зайнято."],
            ['username', 'string', 'min' => 2, 'max' => 255],*/

            ['email', 'filter', 'filter' => 'trim', 'message' => 'Введіть коректну E-mail адресу'],
            ['email', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['email', 'email', 'message' => 'Введіть коректну E-mail адресу'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'Ця адреса електронної пошти вже зайнято.'],

            /*['password', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['password', 'string', 'min' => 6, 'message' => 'Значення «Пароль» повинно містити мінімум 6 символу.'],*/

            ['name', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['name', 'string', 'max' => 255],

            array('password', 'required', 'message' => 'Це поле є обов’язковим для заповнення'),
            array('repeatpassword', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"),

            /*['last_name', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['last_name', 'string', 'max' => 255],*/

            /*['phone', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['phone', 'string', 'max' => 30, 'tooLong'=>'Ведіть корректні дані'],
            [['phone'], 'udokmeci\yii2PhoneValidator\PhoneValidator','country'=>'UA', 'message' => 'Введено невірний формат телефону'],

            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha', 'message' => 'Неправильний код перевірки.'],*/

//            ['rules', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
//            [['rules'], 'integer', 'min' => 1, 'tooSmall'=>'Ви повинні прийняти правила'],
        ];
    }

    public function attributeLabels()
    {
        return [
            //'username' => 'Login - для входу на сайт',
            'password' => 'Пароль',
            'email' => 'Електронна адреса',
            'name' => 'Ім’я та фамілія',
            'rules' => 'Не заперечую проти використання своїх данних',
            'repeatpassword' => 'repeatpassword'
            //'last_name' => 'Прізвище',
            //'phone' => 'Телефон',
            //'verifyCode' => 'Перевірка на людину',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $session = new Session;
        $session->open();
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $generatePassword = $this->generate_password();
            $user->setPassword($generatePassword);
            $user->status = User::STATUS_ACTIVE;
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();
            if ($user->save()) {
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->name = $this->name;
                $profile->save();

                $mailer =  new \yii\swiftmailer\Mailer;


                $mailer->compose()
                    ->setFrom(['welcome@chomu.net' => 'welcome@chomu.net'])
                    ->setTo($this->email)
                    ->setSubject('Email confirmation for ' . Yii::$app->name)
                    ->setTextBody('Plain text content')
                    ->setHtmlBody('<b>HTML content</b>')
                    ->send();

//                $transport = Swift_SmtpTransport::newInstance('smtp.example.org', 25)
//                    ->setUsername('username')
//                    ->setPassword('password');
//
//
//                Yii::$app->mailer->compose()
//                    ->createTransport([
//                        'class' => 'Swift_SmtpTransport',
//                        'host' => 'smtp.gmail.com',
//                        'username' => 'welcome@chomu.net',
//                        'password' => 'mailmechomu',
//                        'port' => '25',
//                        'encryption' => 'TLS'])
//                    ->setFrom([Yii::$app->params['welcomeEmail'] => Yii::$app->name])
//                    ->setTo($this->email)
//                    ->setSubject('Email confirmation for ' . Yii::$app->name)
//                    ->setTextBody('Plain text content')
//                    ->setHtmlBody('<b>HTML content</b>')
//                    ->send();
//                $link = 'test';
//                $message = 'hello your link <a href="http://' . $link . '">' . $link . '</a>';
//
//
//                Yii::$app->mailer->compose()
//                    ->setFrom('chomu.net@gmail.com')
//                    ->setTo($this->email)
//                    ->setSubject('Confirmation subscribes')
//                    ->setHtmlBody($message)
//                    ->send();
            }

            return $user;
        }

        return null;
    }

    public function generate_password($number = 16)
    {
        $arr = array('a', 'b', 'c', 'd', 'e', 'f',
            'g', 'h', 'i', 'j', 'k', 'l',
            'm', 'n', 'o', 'p', 'r', 's',
            't', 'u', 'v', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'R', 'S',
            'T', 'U', 'V', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6',
            '7', '8', '9', '0');
        $pass = "";
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }
}

?>