<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class BookingsTable extends Table
	{

		public function initialize(array $config)
		{
			$this->setTable('booking');
			
			$this->belongsTo('Users', ['foreignKey' => 'userID']);
			$this->belongsTo('Events', ['foreignKey' => 'eventID']);

		}

	}
?>