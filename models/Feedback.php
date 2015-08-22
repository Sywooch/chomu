<?php

namespace app\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property string $getdata
 * @property integer $status
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static $active = [
            '' => '',
            User::STATUS_BLOCKED => 'Новый',
            User::STATUS_ACTIVE => 'Прочитан',
    ]; 

    public static function tableName()
    {
        return '{{%feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'message'], 'required' , 'message' => 'Це поле є обов’язковим для заповнення'],
            ['email', 'filter', 'filter' => 'trim', 'message' => 'Введіть коректну E-mail адресу'],
            ['email', 'email', 'message' => 'Введіть коректну E-mail адресу'],
            [['message'], 'string'],
            [['getdata'], 'safe'],
            [['status'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ім`я та Прізвище',
            'email' => 'E-mail',
            'message' => 'Питання',
            'getdata' => 'Дата',
            'status' => 'Статус',
        ];
    }

    public function saveFeedback()
    {
        if ($this->validate()) {
            $feedback = new Feedback();
            $feedback->name = $this->name;
            $feedback->email = $this->email;
            $feedback->message = $this->message;
            $feedback->getdata = date("Y-m-d H:i:s");
            $feedback->status = 0;
            if (!$feedback->save(false)) true;
            $user = User::find()->where(['role' => 2])->all();
                foreach ($user as $v) {
                    if($v->email != 'admin@mail.ru'){   
                        $mail = Yii::$app->mailer->compose('feedback', ['feedback' => $feedback]);
                        $mail->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name]);
                        if(isset($user) && $user != null){
                            $mail->setTo($v->email); 
                        } else {
                            $mail->setTo(Yii::$app->params['adminEmail']); 
                        }
                        $mail->setSubject('Задати питання');
                        $mail->send();
                    }
                }
            return $feedback;
        }
 
        return null;
    }

    /**
     * @inheritdoc
     * @return FeedbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FeedbackQuery(get_called_class());
    }
}
