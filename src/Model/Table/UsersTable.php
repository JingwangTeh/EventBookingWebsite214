<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;
	use Cake\ORM\Rule\IsUnique;

	class UsersTable extends Table
	{

		public function initialize(array $config)
		{
			$this->setTable('sysuser');
		}

		public function validationDefault(Validator $validator)
		{
			$validator
				->notEmpty('email', 'Email cannot be empty.')
				->notEmpty('username', 'Username cannot be empty.')
				->notEmpty('password', 'Password cannot be empty.');
				
			$validator->add(
				'email',
				['unique' => [
					'rule' => 'validateUnique',
					'provider' => 'table',
					'message' => 'Email already exists.']
				]
			);
			
			$validator->add(
				'username',
				['unique' => [
					'rule' => 'validateUnique',
					'provider' => 'table',
					'message' => 'Username already exists.']
				]
			);
			
			return $validator;
		}

	}
?>