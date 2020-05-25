<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    const VIEW_REPORT = [
        '100',
    ];

    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $fullName = '';

    private static $excludes = [
        //'admin',
    ];

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'Doo3Wo',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => '123',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],

    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
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
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public static function getAllUsers() {
        $result = [];
        foreach (self::$users as $user) {
            if (in_array($user['username'], self::$excludes)) {
                continue;
            }
            $result[] = [
                'id' => $user['id'],
                'username' => $user['username']
            ];
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function findById($id)
    {
        return self::$users[$id]['username'];
    }
}
