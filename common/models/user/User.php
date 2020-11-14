<?php

namespace common\models\user;

use codeonyii\yii2validators\AtLeastValidator;
use common\helper\HelperMethods;
use common\models\ActiveRecord;
use common\models\job\Job;
use common\models\job\JobOffer;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\validators\EmailValidator;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone_number
 * @property string|null $gender
 * @property string|null $user_type
 * @property string|null $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $device_token
 * @property string|null $access_token
 * @property string $email
 * @property int $status
 * @property int $is_verified
 * @property int|null $address_id
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $verification_token
 *
 * @property Job[] $jobs
 * @property JobOffer[] $jobOffers
 * @property UserAddress $address
 * @property UserInterestIn[] $userInterestIns
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const TYPE_ROOT = "root";
    const TYPE_ADMIN = "admin";
    const TYPE_JOB_OWNER = "job_owner";
    const TYPE_EMPLOYEE = "employee";
    const TYPE_CUSTOMER = "customer";
    public $password;

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$this->isNewRecord) {
                $this->updated_at = date("Y-m-d H:i:s");
                if (isset($this->password) && !empty($this->password)) {
                    $this->setPassword($this->password);
                    return true;
                }
            } else if ($this->isNewRecord) {
                $this->created_at = date("Y-m-d H:i:s");
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email'], 'required'],
            [['gender', 'user_type'], 'string'],
            [['status', 'is_verified', 'address_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'first_name', 'last_name', 'phone_number', 'password_hash', 'password_reset_token', 'device_token', 'access_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['first_name'], 'unique'],
            [['last_name'], 'unique'],
            [['phone_number'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['device_token'], 'unique'],
            [['access_token'], 'unique'],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserAddress::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Phone Number',
            'gender' => 'Gender',
            'user_type' => 'User Type',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'device_token' => 'Device Token',
            'access_token' => 'Access Token',
            'email' => 'Email',
            'status' => 'Status',
            'is_verified' => 'Is Verified',
            'address_id' => 'Address ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * Gets query for [[Jobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::className(), ['employee_id' => 'id']);
    }

    public function isRoot()
    {
        return $this->user_type == self::TYPE_ROOT;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Gets query for [[JobOffers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobOffers()
    {
        return $this->hasMany(JobOffer::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(UserAddress::className(), ['id' => 'address_id']);
    }

    /**
     * Gets query for [[UserInterestIns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserInterestIns()
    {
        return $this->hasMany(UserInterestIn::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if (($model = User::findOne(['accessToken' => $token])) != null) {
            return $model;
        }
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public function generateAccessToken()
    {

        $this->accessToken = Yii::$app->security->generateRandomString();
        $this->save();
        return $this->accessToken;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
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
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by [[phone number]]
     *
     * @param $phone_number
     * @param null $user_type
     * @return User|null
     */
    public static function findByPhoneNumber($phone_number, $user_type = null)
    {
        $formattedPhoneNumber = HelperMethods::formatMobileNumber($phone_number);
        if (empty($formattedPhoneNumber)) {
            return null;
        }
        return static::findOne([
            'phone_number' => $formattedPhoneNumber,
            'status' => self::STATUS_ACTIVE,
            'user_type' => $user_type
        ]);
    }

    /**
     * Finds user by [[phone number]]
     *
     * @param $email
     * @param null $user_type
     * @return User|null
     */
    public static function findByEmail($email, $user_type = null)
    {
        $emailValidator = new EmailValidator();
        if (!$emailValidator->validate($email)) {

            return null;
        }

        return self::findOne([
            'email' => $email,
            'status' => self::STATUS_ACTIVE,
            'user_type' => $user_type
        ]);
    }
}
