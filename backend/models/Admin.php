<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $auth_key 令牌
 * @property string $password_hash 密码
 * @property string $password_reset_token
 * @property int $status 0禁用,1激活
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $login_at 登录时间
 * @property int $login_ip 登录IP
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $roles;
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['add'] = ['username','password_hash','status'];
        $scenarios['edit'] = ['username','password_hash','status'];
        return $scenarios;
    }
    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT=>['created_at','updated_at'],
                    self::EVENT_BEFORE_UPDATE=>['created_at']
                ]
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','status'], 'required'],
            [['roles'],'safe'],
            [['password_hash'],'required','on'=>'add'],
            [['password_hash'],'safe','on'=>'edit'],
//            [['username', 'status','password_hash'], 'required'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => '令牌',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'status' => '0禁用,1激活',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'login_at' => '登录时间',
            'login_ip' => '登录IP',
            'roles'=>'角色'
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return Admin::findOne($id);
        // TODO: Implement findIdentity() method.
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
        // TODO: Implement getId() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
//        返回令牌
        return $this->auth_key;
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
//        判断令牌是否一致
        return $this->auth_key===$authKey;
        // TODO: Implement validateAuthKey() method.
    }
}
