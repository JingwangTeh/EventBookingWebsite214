<?php
	namespace App\Model\Entity;

	use Cake\Auth\DefaultPasswordHasher;
	use Cake\ORM\Entity;
	
	class User extends Entity
	{
		// Make all fields mass assignable except for primary key field "id".
		protected $_accessible = [
			'*' => true,
			'id' => false
		];

		protected function _setPassword($password)
		{
			// If password is not empty, hash the password
			// Note: Default hashing algorithm is bcrypt
			if (strlen($password) > 0) {
				return (new DefaultPasswordHasher)->hash($password);
			}
		}
		/*
		public function beforeSave($options = array()) {
			parent::beforeSave($options);
			if (!empty($this->data[$this->alias]['password'])) {
				$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
			}
			
			return true;
		}*/

	}
?>