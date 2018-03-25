<?php
	namespace App\Model\Table;

	use Cake\ORM\Table;
	use Cake\Validation\Validator;

	class EventsTable extends Table
	{
		
		 public function initialize(array $config)
		{
			$this->setTable('event');
			$this->setPrimaryKey('eventID');
			
			$this->belongsTo('Users');
		}
		
	}
?>