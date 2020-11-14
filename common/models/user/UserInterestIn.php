<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "user_interest_in".
 *
 * @property int $id
 * @property int $user_id
 * @property int $interest_id
 *
 * @property Interest $interest
 * @property User $user
 */
class UserInterestIn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_interest_in';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'interest_id'], 'required'],
            [['user_id', 'interest_id'], 'integer'],
            [['interest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Interest::className(), 'targetAttribute' => ['interest_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'interest_id' => 'Interest ID',
        ];
    }

    /**
     * Gets query for [[Interest]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterest()
    {
        return $this->hasOne(Interest::className(), ['id' => 'interest_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
