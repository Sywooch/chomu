<?php

namespace app\models;

use Yii;
use yii\base\Security;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Profile;
use app\models\Vote;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $username
 * @property string $auth_key
 * @property string $email_confirm_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ROLE_USER        = 0;
    const ROLE_MODER       = 1;
    const ROLE_ADMIN       = 2;
    const STATUS_BLOCKED   = 0;
    const STATUS_ACTIVE    = 1;
    const STATUS_WAIT      = 2;
    const SCENARIO_PROFILE = 'profile';

    public $name;
    public $last_name;
    public $phone;
    public $age;
    public $city;
    public $photo;
    public $thumb_photo;
    public static $role       = 0;
    private $_user            = false;
    public $profile;
    public static $statusMess = [
        ''                   => '',
        self::STATUS_BLOCKED => 'Заблокирован',
        self::STATUS_ACTIVE  => 'Активен',
        self::STATUS_WAIT    => 'Ожидает подтверждения',
    ];
    public static $typeUser   = [
        ''               => 'Тип пользователя',
        self::ROLE_USER  => 'User',
        self::ROLE_MODER => 'Moderator',
        self::ROLE_ADMIN => 'Admin'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* ['username', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
              ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
              ['username', 'unique', 'targetClass' => self::className(), 'message' => "Це ім'я користувача вже зайнято."],
              ['username', 'string', 'min' => 2, 'max' => 255], */

            ['email', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['email', 'email', 'message' => 'Введіть коректну E-mail адресу'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'Ця адреса електронної пошти вже зайнято.'],
            ['email', 'string', 'max' => 255],
            ['name', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['name', 'string', 'max' => 255],
            ['last_name', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['last_name', 'string', 'max' => 255],
            ['phone', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['phone', 'string', 'max' => 30, 'tooLong' => 'Ведіть корректні дані'],
            [['phone'], 'udokmeci\yii2PhoneValidator\PhoneValidator', 'country' => 'UA', 'message' => 'Введено невірний формат телефону'],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['username', 'email', 'status'],
            self::SCENARIO_PROFILE => ['email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлён',
            'username'   => 'Имя пользователя',
            'email'      => 'Email',
            'status'     => 'Статус',
            'social_id'  => 'Соци.сети',
            'name'       => 'Ім`я',
            'last_name'  => 'Прізвище',
            'age'        => 'Вік',
            'city'       => 'Місто',
        ];
    }
    /* public static function findIdentity($id) {
      if (Yii::$app->getSession()->has('user-'.$id)) {
      return new self(Yii::$app->getSession()->get('user-'.$id));
      } else {
      return isset(self::$users[$id]) ? new self(self::$users[$id]) : null;
      }
      } */

    public static function findByEAuth($service)
    {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('Не можливо зареєструватися.');
        }

        $id = $service->getServiceName() . '-' . $service->getId();
        /* echo '<pre>';
          var_dump($service);die();
          echo '</pre>'; */

        /* if($service->getServiceName() == 'facebook'){
          $email = '';
          }elseif($service->getServiceName() == 'odnoklassniki'){
          $email = '';
          }elseif($service->getServiceName() == 'vkontakte'){
          $email = $service->getAttribute('email') ? $service->getAttribute('email') : null;
          } */

        $attributes = array(
            'social_id' => $id,
            'username'  => $service->getAttribute('name'),
            'auth_key'  => md5($id),
            'profile'   => $service->getAttributes(),
            //'email' => $email,
        );

        $user = static::findOne(['social_id' => $id]);

        if (isset($user->social_id)) {
            $email = $user->email;
            if ($email == '') {
                $user->email = '';
                $user->save(false);
            }
            if (strripos($email, '@site.com') !== false) {
                if ($service->getServiceName() == 'odnoklassniki') {
                    $user->email = '';
                } else {
                    $user->email = $service->getAttribute('email');
                }
                $user->save(false);
            }
        }

        if (!isset($user->social_id)) {
            $user            = new User();
            $user->social_id = $attributes['social_id'];
            if (isset($attributes['email'])) {
                $user->email = $attributes['email'];
            }
            $password_hash = $user->generate_password();
            $user->setPassword($password_hash);
            $user->role    = 1;
            $user->status  = self::STATUS_ACTIVE;
            $user->profile = json_encode($service->getAttributes());

            $user->save(false);

            Profile::socialSave($user, $service->getAttributes());

            $user = static::findOne(['social_id' => $id]);
        }        

        $user->profile = $service->getAttributes();
        //        $user->photoSoc = $service->getAttribute('photo');
        self::$role    = $user->role;
        Yii::$app->user->login($user, 3600);

        $attributes['profile']['service'] = $service->getServiceName();
        Yii::$app->getSession()->set('user-' . $id, $attributes);
        return new self($attributes);
    }

    public function generate_password($number = 16)
    {
        $arr  = array('a', 'b', 'c', 'd', 'e', 'f',
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

    public function getStatusName()
    {
        $statuses = self::getStatusesArray();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
    }

    public function getRoleName()
    {
        $roles = self::getRoleArray();
        return isset($roles[$this->user_role]) ? $roles[$this->user_role] : '';
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE  => 'Активен',
            self::STATUS_WAIT    => 'Ожидает подтверждения',
        ];
    }

    public function getName()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }
    /* public function getProfile()
      {
      return $this->hasOne(Profile::className(), ['user_id' => 'id']);
      } */

    public static function getRoleArray()
    {
        return [
            ''               => 'Тип пользователя',
            self::ROLE_USER  => 'User',
            self::ROLE_MODER => 'Moderator',
            self::ROLE_ADMIN => 'Admin'
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */

    public static function findIdentityByAccessToken($token, $type = null)
    {
      //  return static::findOne(['email_confirm_token' => $token]);
      throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    /* public static function findByUsername($username)
      {
      return static::findOne(['username' => $username]);
      } */

    public static function findByUsername($email)
    {
        $user = static::findOne(['email' => $email]);
        //self::$role = $user['user_role'];
        return $user;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
                'password_reset_token' => $token,
                'status'               => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire    = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts     = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @param string $email_confirm_token
     * @return static|null
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne(['email_confirm_token' => $email_confirm_token, 'status' => self::STATUS_WAIT]);
    }

    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    public function getTokenUser()
    {
        return Yii::$app->user->login($this->getUser(), 3600);
        //return self::find()->where(['email' => $data[1]['value'], 'password_hash' => $password, 'email_confirm_token' => $data[2]['value']])->one();
    }

    public function setTokenUser($id)
    {
        if (empty($id)) return fasle;
        $user          = self::find()->where([ 'id' => $id])->one();
        $user->satatus = self::STATUS_ACTIVE;
        if ($user->save()) return true;
        else return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->email);
        }

        return $this->_user;
    }

    public static function cheLikeUser($id, $nomination)
    {
        if (isset(Yii::$app->user->identity->id)) {
            if (!isset($id) && $id == null) return false;
            $vote = Vote::find()->where(['user_id' => Yii::$app->user->identity->id, 'story_id' => $id])->one();
            if (!empty($vote) && $vote != null) {
                $story_nomination = Story::find()->where(['id' => $vote->story_id])->one();
                if ($story_nomination->nomination === $nomination) {
                    return true;
                } else return false;
            } else {
                $vote = Vote::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
                $arr  = [];
                foreach ($vote as $k => $v) {
                    $story_nomination = Story::find()->where(['id' => $v->story_id])->one();
                    if ($story_nomination->nomination === $nomination) {
                        $arr[$story_nomination->nomination] = $story_nomination->nomination;
                    }
                }
                if (empty($arr)) {
                    return false;
                } else return true;
            }
        } else return false;
    }
    /* public function getProfile()
      {
      return Profile::find()->where('user_id = :user_id', [':user_id' => $this->id])->one();
      } */

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }
}