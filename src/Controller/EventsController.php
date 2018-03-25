<?php
	namespace App\Controller;
	use App\Controller\AppController;
	use Cake\Event\Event;
	
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\ConnectionManager;
	
	use Cake\I18n\Time;
	
	class EventsController extends AppController {
		
		/*
		 * beforeFilter Function
		 * note: this function is part of the controller's life cycle
		 */
		public function beforeFilter(Event $event){
			// Users who are not logged in can still access the register and logout actions
			$this->Auth->allow(['controller' => 'Events', 'action' => 'browse', 'view']);
		}
		
		/*
		 * initialize Function
		 * note: this function is part of the controller's life cycle
		 */
		public function initialize(){
			parent::initialize();
			$this->loadComponent('Paginator');
		}

		/*
		 * Create Event Function
		 */
		public function add(){
			
			// Set Default Timezone
			date_default_timezone_set('Australia/Canberra');

			// Get All Event Types from eventtype table
			$eventtypes = TableRegistry::get('eventtype')->find();
			$eventTypeNames = [];
			foreach ($eventtypes as $eventtype) { $eventTypeNames[$eventtype['eventTypeName']] = $eventtype['eventTypeName']; }
			$this->set('eventTypeNames', $eventTypeNames);
			
			
			
			// Validate and Add New Event into Database
			if($this->request->is('post')){
				
				/***** Validation *****/
				$newEventValid = true;
				
				// Event About
				$eventTitle = $this->request->data('eventTitle');
				if (empty($eventTitle)) { 
					$newEventValid = false;
					$this->Flash->set('Please provide a title for the event.', ['key'=>'eventTitleErr']);
				}
				$eventDesc = $this->request->data('eventDesc');
				if (empty($eventDesc)) { 
					$newEventValid = false;
					$this->Flash->set('Please provide a description for the event.', ['key'=>'eventDescErr']);
				}
				$eventType = $this->request->data('eventType');
				if (empty($eventType)) { 
					$newEventValid = false; 
					$this->Flash->set('Please provide a valid event type for the event.', ['key'=>'eventTypeErr']);
				}
				
				// Event Details
				$eventStartDate = $this->request->data('eventStartDate'); 
				$now = new Time();
				if (empty($eventStartDate)) { 
					//$eventStartDate = new \DateTime();
					$newEventValid = false; 
					$this->Flash->set('Please provide a start date for the event.', ['key'=>'eventStartDateErr']);
				}
				else if ($eventStartDate < $now->i18nFormat('YYY/MM/dd HH:00')){
					$newEventValid = false;
					$this->Flash->set('Event Start Date should be later than now.', ['key'=>'eventStartDateErr']);	
				}
				$eventEndDate = $this->request->data('eventEndDate');
				if (empty($eventEndDate)) { 
					//$eventEndDate = new \DateTime(); 
					$newEventValid = false; 
					$this->Flash->set('Please provide an end date for the event.', ['key'=>'eventEndDateErr']);
				}
				else if ($eventEndDate <= $eventStartDate){
					$newEventValid = false; 
					$this->Flash->set('Event End Date should be later than the event start date.', ['key'=>'eventEndDateErr']);
				}
				$eventLocation = $this->request->data('eventLocation');
				if (empty($eventLocation)) { 
					$newEventValid = false;
					$this->Flash->set('Please provide a location for the event.', ['key'=>'eventLocationErr']);
				}
				
				// Event Advanced Details
				$eventTotalCapacity = $this->request->data('eventTotalCapacity');
				if (empty($eventTotalCapacity)) { 
					$newEventValid = false;
					$this->Flash->set('Please provide the total allowable participants for the event.', ['key'=>'eventTotalCapacityErr']);
				}
				$eventPrice = $this->request->data('eventPrice');
				if (empty($eventPrice) && $eventPrice !== "0") { 
					$newEventValid = false; 
					$this->Flash->set('Please provide an entrance fee for the event.', ['key'=>'eventPriceErr']);
				}
				$eventPromoCode = $this->request->data('eventPromoCode');
				if (empty($eventPromoCode)){ $eventPromoCode = null;
				}
				$eventDiscountPercent = $this->request->data('eventDiscountPercent');
				if (empty($eventDiscountPercent)){ $eventDiscountPercent = 0; 
				}
				
				// Event Host
				$eventHost = $this->Auth->user('username');
				
				/***** Validation End *****/
				
				if ($newEventValid){
					// Submit New Event Entry
					$events_table = TableRegistry::get('event');
					$events_query = $events_table->query();
					$events_query->insert(['eventTitle', 'eventDesc', 'eventType',
										   'eventStartDate', 'eventEndDate', 'eventLocation',
										   'eventTotalCapacity', 'eventPrice', 'eventPromoCode', 'eventDiscountPercent',
										   'eventHost'])
								 ->values([
									'eventTitle' => $eventTitle,
									'eventDesc' => $eventDesc,
									'eventType' => $eventType,
									'eventStartDate' => $eventStartDate,
									'eventEndDate' => $eventEndDate,
									'eventLocation' => $eventLocation,
									'eventTotalCapacity' => $eventTotalCapacity,
									'eventPrice' => $eventPrice,
									'eventPromoCode' => $eventPromoCode,
									'eventDiscountPercent' => $eventDiscountPercent,
									'eventHost' => $eventHost
									])
								->execute();
					
					$this->Flash->set('Event Successfully Created.', ['key' => 'eventCreationSuccess']);
					
					return $this->redirect([
						'controller' => 'Users',
						'action' => 'event'
					]);
				}
				// Validation Failed
				else { }
				
			}
		}

		/*
		 * Edit Event Function
		 */
		public function edit(){
			
			// Get All Event Types from eventtype table
			$eventtypes = TableRegistry::get('eventtype')->find();
			$eventTypeNames = [];
			foreach ($eventtypes as $eventtype) { $eventTypeNames[$eventtype['eventTypeName']] = $eventtype['eventTypeName']; }
			$this->set('eventTypeNames', $eventTypeNames);
			
			// Get EventID from GET & POST
			// - GET request from user home
			// - POST request from same URL when refreshing page
			if($this->request->is('get')) { $eventID = $this->request->getQuery('eventID'); }
			else if($this->request->is('post')) { $eventID = $this->request->data('eventID'); }
			$username = $this->Auth->user('username');
			
			// Get Details for the Specified Event
			$events = TableRegistry::get('event')
							->find()
							->where(['eventID'=>$eventID])
							->andWhere(['eventHost'=>$username])
							->first();
			
			// If query did not return any event,
			// which means that the event requested is not hosted by the user,
			// and that the user should not be able to edit it
			if(empty($events)) {
				// redirect user back to user's home page
				return $this->redirect([
					'controller' => 'Users',
					'action' => 'home'
				]);
			}
			
			// display current event values
			$this->set('eventID', $eventID);
			$this->set('event', $events);
			
			
			
			// update new values after form submission
			if($this->request->is('post')){

				/***** Validation *****/
				$newEventValid = true;
				
				// Event About
				$eventTitle = $this->request->data('eventTitle');
				if (empty($eventTitle)) { 
					$newEventValid = false;
					$this->Flash->set('Please provide a title for the event.', ['key'=>'eventTitleErr_Edit']);
				}
				$eventDesc = $this->request->data('eventDesc');
				if (empty($eventDesc)) { 
					$newEventValid = false;
					$this->Flash->set('Please provide a description for the event.', ['key'=>'eventDescErr_Edit']);
				}
				$eventType = $this->request->data('eventType');
				if (empty($eventType)) { 
					$newEventValid = false; 
					$this->Flash->set('Please provide a valid event type for the event.', ['key'=>'eventTypeErr_Edit']);
				}
				
				// Event Details
				$eventStartDate = $this->request->data('eventStartDate');
				$now = new Time();
				if (empty($eventStartDate)) { 
					//$eventStartDate = new \DateTime();
					$newEventValid = false; 
					$this->Flash->set('Please provide a start date for the event.', ['key'=>'eventStartDateErr_Edit']);
				}
				else if ($eventStartDate < $now->i18nFormat('YYY/MM/dd HH:00')){
					$newEventValid = false;
					$this->Flash->set('Event Start Date should be later than now.', ['key'=>'eventStartDateErr_Edit']);	
				}
				$eventEndDate = $this->request->data('eventEndDate');
				if (empty($eventEndDate)) { 
					//$eventEndDate = new \DateTime(); 
					$newEventValid = false; 
					$this->Flash->set('Please provide an end date for the event.', ['key'=>'eventEndDateErr_Edit']);
				}
				else if ($eventEndDate <= $eventStartDate){
					$newEventValid = false; 
					$this->Flash->set('Event End Date should be later than the event start date.', ['key'=>'eventEndDateErr_Edit']);
				}
				$eventLocation = $this->request->data('eventLocation');
				if (empty($eventLocation)) { 
					$newEventValid = false;
					$this->Flash->set('Please provide a location for the event.', ['key'=>'eventLocationErr_Edit']);
				}
				
				// Event Advanced Details
				$eventTotalCapacity = $this->request->data('eventTotalCapacity');
				if (empty($eventTotalCapacity)) { 
					$newEventValid = false;
					$this->Flash->set('Please provide the total allowable participants for the event.', ['key'=>'eventTotalCapacityErr_Edit']);
				}
				$eventPrice = $this->request->data('eventPrice');
				if (empty($eventPrice) && $eventPrice !== "0") {
					$newEventValid = false; 
					$this->Flash->set('Please provide an entrance fee for the event.', ['key'=>'eventPriceErr_Edit']);
				}
				$eventPromoCode = $this->request->data('eventPromoCode');
				if (empty($eventPromoCode)){ $eventPromoCode = null;
				}
				$eventDiscountPercent = $this->request->data('eventDiscountPercent');
				if (empty($eventDiscountPercent)){ $eventDiscountPercent = 0; 
				}
				
				// Event Host
				$eventHost = $this->Auth->user('username');
				
				/***** Validation End *****/
				
				if ($newEventValid){
					// Update Event Details
					$eventQuery = TableRegistry::get('event')->query();
					$eventQuery ->update()
								->set(['eventTitle' => $eventTitle,
									   'eventDesc' => $eventDesc,
									   'eventType' => $eventType,
									   'eventStartDate' => $eventStartDate,
									   'eventEndDate' => $eventEndDate,
									   'eventLocation' => $eventLocation,
									   'eventTotalCapacity' => $eventTotalCapacity,
									   'eventPrice' => $eventPrice,
									   'eventPromoCode' => $eventPromoCode,
									   'eventDiscountPercent' => $eventDiscountPercent
								])
								->where(['eventID'=>$eventID])
								->andWhere(['eventHost'=>$username])
								->execute();

					// Get Updated Details
					$newEvent = TableRegistry::get('event')
									->find()
									->where(['eventID'=>$eventID])
									->andWhere(['eventHost'=>$username])
									->first();
					
					// overwrite previous event values
					$this->set('eventID', $eventID);
					$this->set('event', $newEvent);
					
					$this->Flash->set('Event Successfully Updated.', ['key' => 'eventUpdateSuccess']);
					
					return $this->redirect([
						'controller' => 'Users',
						'action' => 'event'
					]);
				} // Validation Failed
				
			}
			
		}
		
		/*
		 * Manage Event Function (Launch/Cancel Event, Delete/UndoDelete Event)
		 */
		public function manage(){
			
			// Get EventID from GET & POST
			// - GET request from user home
			// - POST request from same URL when refreshing page
			if($this->request->is('get')) { $eventID = $this->request->getQuery('eventID'); }
			else if($this->request->is('post')) { $eventID = $this->request->data('eventID'); }
			$username = $this->Auth->user('username');
			
			
			
			// Get Details for the Specified Event
			$events = TableRegistry::get('event')
							->find()
							->where(['eventID'=>$eventID])
							->andWhere(['eventHost'=>$username])
							->first();
			
			// If query did not return any event,
			// which means that the event requested is not hosted by the user,
			// and that the user should not be able to edit it
			if(empty($events)) {
				// redirect user back to user's home page
				return $this->redirect([
					'controller' => 'Users',
					'action' => 'home'
				]);
			}
			
			// display current event values
			$this->set('eventID', $eventID);
			$this->set('event', $events);
			
			
			
			// update new values after form submission
			if($this->request->is('post'))
			{
				// Update Event Status
				if (!empty($this->request->data('eventStatus')))
				{
					if ($this->request->data('eventStatus') == 'launch') {	$eventStatus = 1;	}
					else if ($this->request->data('eventStatus') == 'cancel') {	$eventStatus = 0;	}
					
					$eventQuery = TableRegistry::get('event')->query();
					$eventQuery ->update()
								->set(['eventStatus' => $eventStatus])
								->where(['eventID'=>$eventID])
								->andWhere(['eventHost'=>$username])
								->execute();
								
					$newEvent = TableRegistry::get('event')
						->find()
						->where(['eventID'=>$eventID])
						->andWhere(['eventHost'=>$username])
						->first();
					
					// overwrite previous event values
					$this->set('eventID', $eventID);
					$this->set('event', $newEvent);
				}
				else if (!empty($this->request->data('eventMarkForDeletion')))
				{
					if ($this->request->data('eventMarkForDeletion') == 'toDelete') {	$eventMarkForDeletion = 1;	}
					else if ($this->request->data('eventMarkForDeletion') == 'undoDelete') {	$eventMarkForDeletion = 0;	}
					
					$eventQuery = TableRegistry::get('event')->query();
					$eventQuery ->update()
								->set(['eventMarkForDeletion' => $eventMarkForDeletion])
								->where(['eventID'=>$eventID])
								->andWhere(['eventHost'=>$username])
								->execute();

					$newEvent = TableRegistry::get('event')
						->find()
						->where(['eventID'=>$eventID])
						->andWhere(['eventHost'=>$username])
						->first();
					
					// overwrite previous event values
					$this->set('eventID', $eventID);
					$this->set('event', $newEvent);
				}
			}
			
		}
		
		/*
		 * Browse All Events Function
		 */
		public function browse(){
			$now = Time::now();

			// Set paginator settings
			$this -> paginate['limit'] = 5;
			$this -> paginate['order'] = ['event.eventTitle' => 'asc'];
			
			// Get All Available Events
			$events_table = TableRegistry::get('event')
								->find()
								->where(['eventStatus'=>1])
								->where(['eventMarkForDeletion'=>0])
								->andWhere(function($exp) use($now) {
									$exp->gte('eventStartDate', $now);
									return $exp;
								})
								->andWhere('eventTotalCapacity > eventCurrentCapacity');
			$this->set('eventList', $this->paginate($events_table));
			
			// Get All Event Titles
			$eventTitles = TableRegistry::get('event')
								->find()
								->where(['eventStatus'=>1])
								->where(['eventMarkForDeletion'=>0])
								->andWhere(function($exp) use($now) {
									$exp->gte('eventStartDate', $now);
									return $exp;
								})
								->andWhere('eventTotalCapacity > eventCurrentCapacity')
								->extract('eventTitle');
			$this->set('eventTitles', $eventTitles);
			
			if ($this->request->is('post')){
				$eventTitle = $this->request->data('eventTitle');
				$this->set('selectedTitle', $eventTitle);
				
				// Get All Available Events according to event type and event title
				$events_table = TableRegistry::get('event')
									->find()
									->where(['eventStatus'=>1])
									->where(['eventMarkForDeletion'=>0])
									->andWhere(function($exp) use($now) {
										$exp->gte('eventStartDate', $now);
										return $exp;
									})
									->andWhere('eventTotalCapacity > eventCurrentCapacity')
									->andWhere(['eventTitle LIKE'=>'%'.$eventTitle.'%']);
				$this->set('eventList', $this->paginate($events_table));
			}
			
		}
		
		/*
		 * View Specific Event Function
		 */
		public function view(){
			
			if($this->request->is('get')) {
				// Get Event Details
				$eventID = $this->request->getQuery('eventID');
				$events = TableRegistry::get('event')
								->find()
								->where(['eventStatus'=>1])
								->where(['eventMarkForDeletion'=>0])
								->where(['eventID'=>$eventID])
								->first();
								
				if (empty($events)){
					if ($this->Auth->user()) {
						return $this->redirect(
							['controller' => 'Users', 'action' => 'Home']
						);
					} else {
						return $this->redirect([
							'controller' => 'Events',
							'action' => 'browse'
						]);	
					}
				}
				
				$this->set('event', $events);
					
				// Get Booking Details (to prevent booking an already booked event)
				$bookings = TableRegistry::get('booking')
								->find()
								->where(['eventID'=>$eventID])
								->andWhere(['userID'=>$this->Auth->user('id')])
								->first();
				$this->set('booking', $bookings);
			}
			else if (!$this->request->is('get')){
				return $this->redirect([
					'controller' => 'Events',
					'action' => 'browse'
				]);
			}
			
		}
		
	}
?>