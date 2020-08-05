<?php

namespace app\models\cases;

use Yii;
use yii\base\Model;
use app\models\entities\Users;

/**
 * RegisterForm is the model behind the login form.
 *
 *
 */
class RegisterForm extends Model
{
    public $login;
    public $password;
    public $repeatPassword;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['login', 'password', 'repeatPassword'], 'required'],
            ['password', 'validatePassword'],
            ['login', 'unique', 'targetClass' => '\app\models\entities\Users', 'message' => Yii::t('app', 'This login has already been taken')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'login'     => Yii::t('app', Yii::t('app', 'Username')),
            'password'     => Yii::t('app', Yii::t('app', 'Password')),
            'repeatPassword'   => Yii::t('app', Yii::t('app', 'Repeat password'))
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {

            if ($this->password != $this->repeatPassword) {
                $this->addError($attribute, Yii::t('app', 'The passwords are not matches'));
            }
        }
    }

    /**
     * creates new user in DataBase
     *
     * @return Users|null the saved model or null if saving fails
     */
    public function createUser()
    {
        if (!$this->validate())
            return null;

        $user           = new Users();
        $user->login    = $this->login;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            return $user;
        }

        return null;
    }

    /**
     * Finds user by [[login]]
     *
     * @return Users|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Users::findByUsername($this->login);
        }

        return $this->_user;
    }
}
