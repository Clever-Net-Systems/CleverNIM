<?php

/**
 * NovellIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class NovellIdentity extends CUserIdentity {
	private $_id;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authlocal() {
		if (strpos($this->username,"@")) {
			$user=User::model()->notsafe()->findByAttributes(array('email'=>$this->username));
		} else {
			$user=User::model()->notsafe()->findByAttributes(array('username'=>$this->username));
		}
		if($user===null)
			if (strpos($this->username,"@")) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
			else if(md5($this->password)!==$user->password)
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			else if($user->status == "registered")
				$this->errorCode=self::ERROR_STATUS_NOTACTIV;
			else if($user->status == "banned")
				$this->errorCode=self::ERROR_STATUS_BAN;
			else {
				$this->_id=$user->id;
				$this->username=$user->username;
				$this->errorCode=self::ERROR_NONE;
			}
		return !$this->errorCode;
	}

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		/* First try local */
		$this->authlocal();
		if ($this->errorCode === self::ERROR_NONE) {
			return !$this->errorCode;
		}
		/* Local authentication was unsuccessful, move on to next authentication mechanism */
		if (strpos($this->username,"@")) {
			$user=User::model()->notsafe()->findByAttributes(array('email'=>$this->username));
		} else {
			$user=User::model()->notsafe()->findByAttributes(array('username'=>$this->username));
		}
		if($user===null)
			if (strpos($this->username,"@")) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
			else if($user->status == "registered")
				$this->errorCode=self::ERROR_STATUS_NOTACTIV;
			else if($user->status == "banned")
				$this->errorCode=self::ERROR_STATUS_BAN;
			else {
				$options = Yii::app()->params['ldap'];
				$connection = ldap_connect($options['host'], $options['port']);
				ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, $options['version']);
				ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
				if ($options['start_tls']) {
					ldap_start_tls($connection);
				}
				if (!$connection) {
					$this->errorCode=self::ERROR_USERNAME_INVALID;
				} else {
					/* TODO Donner la possibilité de faire un stack de authentication providers */
					/* TODO Implémenter local, DB, CAS, AD, OpenLDAP, Novell, PAM, always_ok et user==password */
					//$bind = @ldap_bind($connection, "cn=" . $this->username . "," . $options['base'], $this->password);
					$bind = @ldap_bind($connection); /* Anonyme */
					$ldapres = ldap_search($connection, "ou=gaz5,ou=a,o=hdf", "(cn=" . $this->username . ")", array("dn"));
					$entries = ldap_get_entries($connection, $ldapres);
					if ($entries['count'] !== 1) {
						$this->errorCode=self::ERROR_USERNAME_INVALID;
					} else {
						$dn = $entries[0]['dn'];
						$bind = @ldap_bind($connection, $dn, $this->password);
						if (!$bind) {
							$this->errorCode = self::ERROR_PASSWORD_INVALID;
						} else {
							$this->_id = $user->id;
							$this->username = $user->username;
							$this->errorCode = self::ERROR_NONE;
						}
					}
				}
			}
		return !$this->errorCode;




		$options = Yii::app()->params['ldap'];
		$connection = ldap_connect($options['host'], $options['port']);
		ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, $options['version']);
		ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
		if ($options['start_tls']) {
			ldap_start_tls($connection);
		}
		if ($connection) {
			/* TODO Faire un search pour quand on connait pas le base, ou laisser le user spécifier le DN */
			/* TODO Donner la possibilité de faire un stack de authentication providers */
			/* TODO Implémenter local, DB, CAS, AD, OpenLDAP, Novell, PAM et user==password */
			$bind = ldap_bind($connection, "cn=" . $this->username . "," . $options['base'], $this->password);

			if (!$bind)
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			else
				$this->errorCode = self::ERROR_NONE;
		}
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId() {
		return $this->_id;
	}
}
