<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
    const ROLE_USER  = 0;
    const ROLE_MODER = 1;
    const ROLE_ADMIN = 2;
    const STATUS_BLOCKED            = 0;
    const STATUS_ACTIVE             = 1;
    const STATUS_WAIT               = 2;
    const SCENARIO_PROFILE          = 'profile';

    public $name;
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
    public static $role       = 0;

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

            [['role, username, email, status'], 'safe'],
            ['email', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'Ця адреса електронної пошти вже зайнято.'],
            ['email', 'string', 'max' => 255],
            ['name', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['name', 'string', 'max' => 255],
            ['last_name', 'required', 'message' => 'Це поле є обов’язковим для заповнення'],
            ['last_name', 'string', 'max' => 255],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],
            ['user_role', 'integer'],
            ['user_role', 'default', 'value' => self::STATUS_BLOCKED],
            ['user_role', 'in', 'range' => array_keys(self::getRoleArray())],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['email', 'status', 'name', 'role'],
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
            'role'       => 'Роль пользователя',
            'status'     => 'Статус',
            'name'       => 'Ім`я',
        ];
    }

    public function getStatusName()
    {
        $statuses = self::getStatusesArray();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE  => 'Активен',
            self::STATUS_WAIT    => 'Ожидает подтверждения',
        ];
    }

    public function getRoleName()
    {
        $roles = self::getRoleArray();
        return isset($roles[$this->user_role]) ? $roles[$this->user_role] : '';
    }

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

    public function getName()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    /* public static function findIdentity($id)
      {
      $user = static::findOne($id);
      self::$role = $user['user_role'];
      return $user;
      } */

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
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
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
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

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'user_id']);
    }
}