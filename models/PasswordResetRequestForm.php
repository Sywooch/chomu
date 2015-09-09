<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;
use yii\web\Session;
use yii\helpers\Url;
/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim', 'message' => 'Введіть коректну E-mail адресу'],
            ['email', 'required'],
            ['email', 'email', 'message' => 'Введіть коректну E-mail адресу'],
            ['email', 'exist',
                'targetClass' => 'app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Нема користувача з такою E-mail адресою.'
            ],
        ];
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */

    public function sendEmail()
    {
        /* @var $user User */

        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
        if ($user) {
            $user->generatePasswordResetToken();

            if ($user->save()) {
                return Yii::$app->mailer->compose()
                    ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
                    ->setTo($user->email)
                    ->setSubject('Відновлення пароля для ' . Yii::$app->name)
                    ->setHtmlBody("Для восстановления пароля перейдите по ссылке: <a href='" .Url::toRoute('/site/index')."token=$user->password_reset_token'>token=$user->password_reset_token</a>")
                    ->send();
            }
        }
        return false;
    }

}