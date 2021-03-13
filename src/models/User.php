<?php

namespace baseapi\models;

use BaseApi;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    public $newPassword;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstName','lastName','email'], 'required'],
            ['admin','default', 'value' => 'N'],
            ['password','default', 'value' => ''],
            ['username','default', 'value' => ''],
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['authKey' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        /**
         * TODO: research what to do about this.  This was changed with Yii 2.0.40 - here are the notes from the
         * change log
         *
         * The methods `getAuthKey()` and `validateAuthKey()` of `yii\web\IdentityInterface` are now also used to validate active
        sessions (previously these methods were only used for cookie-based login). If your identity class does not properly
        implement these methods yet, you should update it accordingly (an example can be found in the guide under
        `Security` -> `Authentication`). Alternatively, you can simply return `null` in the `getAuthKey()` method to keep
        the old behavior (that is, no validation of active sessions). Applications that change the underlying `authKey` of
        an authenticated identity, should now call `yii\web\User::switchIdentity()`, `yii\web\User::login()`
        or `yii\web\User::logout()` to recreate the active session with the new `authKey`.

         *
         */
        return null;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    public function add()
    {
        $this->password = BaseApi::$app->getSecurity()->generatePasswordHash($this->newPassword, 13);
        $this->authKey = BaseApi::$app->getSecurity()->generateRandomString();

        if (($this->password == '') || ($this->username == '')) {
            return false;
        }

        if ($this->validate()) {
            $this->save();

            return true;
        } else {
            return false;
        }
    }

    public function updateUser()
    {
        if ($this->validate()) {

            $updatedUser = BaseApi::$app->request->post();

            if (isset($updatedUser['password'])) {
                $updatedUser['password'] = BaseApi::$app->getSecurity()->generatePasswordHash($updatedUser['password']);
            }

            $user = static::findOne(BaseApi::$app->request->post("id"));
            $user->attributes = $updatedUser;
            $user->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns a list of users without the password / token information
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUsers() {
        return static::find()
            ->select(['id', 'firstName','lastName', 'username', 'email', 'admin'])
            ->all();
    }
}