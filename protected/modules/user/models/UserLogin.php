<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UserLogin extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>Yii::t('app',"Remember me next time"),
			'username'=>Yii::t('app',"username or email"),
			'password'=>Yii::t('app',"password"),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$identity=new UserIdentity($this->username,$this->password);
			$identity->authenticate();
                        
                        //check any offline setup enabled
                        $offline_status= SystemOfflineSettings::model()->updateStatus();
                        if($offline_status==1)
                        {
                            if($identity->errorCode==0)
                            {
                                //check user login is allowed in offline period
                               $user_login_status= SystemOfflineSettings::model()->checkUpdate($this->username);
                               if($user_login_status==1)
                               {
                                                    switch($identity->errorCode)
                                                     {
                                                     case UserIdentity::ERROR_NONE:
                                                             $duration=$this->rememberMe ? Yii::app()->controller->module->rememberMeTime : 0;
                                                             Yii::app()->user->login($identity,$duration);
                                                             break;
                                                     case UserIdentity::ERROR_EMAIL_INVALID:
                                                             $this->addError("username",Yii::t('app',"Email is incorrect."));
                                                             break;
                                                     case UserIdentity::ERROR_USERNAME_INVALID:
                                                             $this->addError("username",Yii::t('app',"Username is incorrect."));
                                                             break;
                                                     case UserIdentity::ERROR_STATUS_NOTACTIV:
                                                             $this->addError("status",Yii::t('app',"You account is not activated."));
                                                             break;
                                                     case UserIdentity::ERROR_STATUS_BAN:
                                                             $this->addError("status",Yii::t('app',"You account is blocked."));
                                                             break;
                                                     case UserIdentity::ERROR_PASSWORD_INVALID:
                                                             $this->addError("password",Yii::t('app',"Password is incorrect."));
                                                             break;
                                                     }
                                   }
                                   else
                                   {
                                       //redirect to offline message page
                                       $url = Yii::app()->createUrl('site/offline');
                                       Yii::app()->request->redirect($url);
                                   }
                            }
                            else
                            {
                                switch($identity->errorCode)
                                {
				case UserIdentity::ERROR_NONE:
					$duration=$this->rememberMe ? Yii::app()->controller->module->rememberMeTime : 0;
					Yii::app()->user->login($identity,$duration);
					break;
				case UserIdentity::ERROR_EMAIL_INVALID:
					$this->addError("username",Yii::t('app',"Email is incorrect."));
					break;
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError("username",Yii::t('app',"Username is incorrect."));
					break;
				case UserIdentity::ERROR_STATUS_NOTACTIV:
					$this->addError("status",Yii::t('app',"You account is not activated."));
					break;
				case UserIdentity::ERROR_STATUS_BAN:
					$this->addError("status",Yii::t('app',"You account is blocked."));
					break;
				case UserIdentity::ERROR_PASSWORD_INVALID:
					$this->addError("password",Yii::t('app',"Password is incorrect."));
					break;
                                }
                            }
                        }
                        else
                        {                        
                            switch($identity->errorCode)
                            {
                                    case UserIdentity::ERROR_NONE:
                                            $duration=$this->rememberMe ? Yii::app()->controller->module->rememberMeTime : 0;
                                            Yii::app()->user->login($identity,$duration);
                                            break;
                                    case UserIdentity::ERROR_EMAIL_INVALID:
                                            $this->addError("username",Yii::t('app',"Email is incorrect."));
                                            break;
                                    case UserIdentity::ERROR_USERNAME_INVALID:
                                            $this->addError("username",Yii::t('app',"Username is incorrect."));
                                            break;
                                    case UserIdentity::ERROR_STATUS_NOTACTIV:
                                            $this->addError("status",Yii::t('app',"You account is not activated."));
                                            break;
                                    case UserIdentity::ERROR_STATUS_BAN:
                                            $this->addError("status",Yii::t('app',"You account is blocked."));
                                            break;
                                    case UserIdentity::ERROR_PASSWORD_INVALID:
                                            $this->addError("password",Yii::t('app',"Password is incorrect."));
                                            break;
                            }
                        }
		}
	}
}
