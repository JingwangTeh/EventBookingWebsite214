<?php
	namespace App\Controller;
	use App\Controller\AppController;
	use Cake\Event\Event;
	
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\ConnectionManager;
	
	class BookingsController extends AppController {
		
		/*
		 * Add Booking Function (Accessible through form submission only)
		 */
		public function add(){
			
			if($this->request->is('post')){
				
				/* Add event-user booking record into database */
				
				$eventID = $this->request->data('eventID');
				$userID = $this->Auth->user('id');
				
				
				// get promocode & current capacity
				$promoCode = $this->request->data('promoCode');
				$targetEvent = TableRegistry::get('event')
								->find()
								->where(['eventID'=>$eventID])
								->first();
				$targetEventCode = $targetEvent->eventPromoCode;
				$targetCapacity = $targetEvent->eventCurrentCapacity;
				
				// compare promocode
				if (!empty($targetEventCode) && !empty($promoCode))
				{
					if ($targetEventCode == $promoCode)
					{
						// Update Event Current Capacity
						$targetCapacity++;
						
						// Full Capacity already
						if ($targetCapacity > $targetEvent->eventTotalCapacity)
						{
							$this->Flash->error('Event Failed to Book as event is full.', ['key' => 'eventBookingFailed']);
						
							/* Redirect user back to event details page */
							return $this->redirect([
								'controller' => 'Events',
								'action' => 'view',
								"eventID" => $eventID
							]);
						}
						
						// Not Yet Full Capacity
						$eventQuery = TableRegistry::get('event')->query();
						$eventQuery ->update()
									->set(['eventCurrentCapacity' => $targetCapacity])
									->where(['eventID'=>$eventID])
									->execute();
									
						$this->Flash->success('Event Successfully Booked with Promo Code.', ['key' => 'eventBookingSuccess']);
						
						// Add Booking Entry
						$bookings_table = TableRegistry::get('booking');
						$bookings_query = $bookings_table->query();
						$bookings_query->insert(['eventID', 'userID', 'currentDiscountPercent'])
									 ->values([
										'eventID' => $eventID,
										'userID' => $userID,
										'currentDiscountPercent' => $targetEvent->eventDiscountPercent
										])
									->execute();
									
						/* Redirect user back to event details page */
						return $this->redirect([
							'controller' => 'Users',
							'action' => 'booking',
							"eventID" => $eventID
						]);
					}
					else
					{
						$this->Flash->error('Event Failed to Book as Promo Code was incorrect.', ['key' => 'eventBookingFailed']);
						
						/* Redirect user back to event details page */
						return $this->redirect([
							'controller' => 'Events',
							'action' => 'view',
							"eventID" => $eventID
						]);
					}
				}
				else
				{
					// Update Event Current Capacity
					$targetCapacity++;
					
					// Full Capacity already
					if ($targetCapacity > $targetEvent->eventTotalCapacity)
					{
						$this->Flash->error('Event Failed to Book as event is full.', ['key' => 'eventBookingFailed']);
					
						/* Redirect user back to event details page */
						return $this->redirect([
							'controller' => 'Events',
							'action' => 'view',
							"eventID" => $eventID
						]);
					}
					
					// Not Yet Full Capacity
					$eventQuery = TableRegistry::get('event')->query();
					$eventQuery ->update()
								->set(['eventCurrentCapacity' => $targetCapacity])
								->where(['eventID'=>$eventID])
								->execute();

					$this->Flash->success('Event Successfully Booked.', ['key' => 'eventBookingSuccess']);
					
					$bookings_table = TableRegistry::get('booking');
					$bookings_query = $bookings_table->query();
					$bookings_query->insert(['eventID', 'userID'])
								 ->values([
									'eventID' => $eventID,
									'userID' => $userID
									])
								->execute();
								
					/* Redirect user back to event details page */
					return $this->redirect([
						'controller' => 'Users',
						'action' => 'booking',
						"eventID" => $eventID
					]);
				}

			}
		}
		
		/*
		 * Remove Booking Function (Accessible through form submission only)
		 */
		public function remove(){
			
			if($this->request->is('post')){
				
				/* Remove event-user booking record from database */
				
				$eventID = $this->request->data('eventID');
				$userID = $this->Auth->user('id');
				
				$bookedEvents = TableRegistry::get('booking')
									->find()
									->where(['eventID'=>$eventID])
									->andWhere(['userID'=>$userID])
									->first();

				// redirect back to home if invalid booking entry
				if(empty($bookedEvents)) {
					return $this->redirect([
						'controller' => 'Users',
						'action' => 'home'
					]);
				}
				
				// Delete booking record
				$bookedEventsQuery = TableRegistry::get('booking')->query();
				$bookedEventsQuery->delete()
								  ->where(['eventID'=>$eventID])
								  ->andWhere(['userID'=>$this->Auth->user('id')])
								  ->execute();

				// get current capacity
				$targetEvent = TableRegistry::get('event')
								->find()
								->where(['eventID'=>$eventID])
								->first();
				$targetCapacity = $targetEvent->eventCurrentCapacity;
				
				// Update Event Current Capacity
				$targetCapacity--;
				$eventQuery = TableRegistry::get('event')->query();
				$eventQuery ->update()
							->set(['eventCurrentCapacity' => $targetCapacity])
							->where(['eventID'=>$eventID])
							->execute();
			
				$this->Flash->success('Event Successfully Withdrawn.', ['key' => 'eventWithdrawSuccess']);
					
				// Redirect user back to event details page
				return $this->redirect([
					'controller' => 'Events',
					'action' => 'view',
					"eventID" => $eventID
				]);
			}

		}
	
		/*
		 * Edit Bookings 
		 */
		public function update(){
			
			if($this->request->is('post')){
				$eventID = $this->request->data('eventID');
				$userID = $this->Auth->user('id');
				
				
				// get promocode & current capacity
				$promoCode = $this->request->data('promoCode');
				$targetEvent = TableRegistry::get('event')
								->find()
								->where(['eventID'=>$eventID])
								->first();
				$targetEventCode = $targetEvent->eventPromoCode;
				
				// compare promocode
				if (!empty($targetEventCode) && !empty($promoCode))
				{
					if ($targetEventCode == $promoCode)
					{
						// Update Booking Entry
						$bookingsQuery = TableRegistry::get('booking')->query()
											->update()
											->set([
												'currentDiscountPercent' => $targetEvent->eventDiscountPercent
											])
											->where(['eventID' => $eventID])
											->andWhere(['userID' => $userID])
											->execute();

						$this->Flash->success('Booking details updated successfully.', ['key' => 'bookingUpdateSuccess']);
					}
					else
					{
						// invalid promocode
						$this->Flash->error('Promocode is invalid.', ['key' => 'bookingUpdateFailed']);
					}
				}
				else if (!empty($targetEventCode) && empty($promoCode))
				{
					// Update Booking Entry
					$bookingsQuery = TableRegistry::get('booking')->query()
										->update()
										->set([
											'currentDiscountPercent' => 0
										])
										->where(['eventID' => $eventID])
										->andWhere(['userID' => $userID])
										->execute();

					$this->Flash->success('Booking details updated successfully.', ['key' => 'bookingUpdateSuccess']);
				}
				else
				{
					// promocode was not set for this event
					$this->Flash->error('There is no promocode available for this event.', ['key' => 'bookingUpdateFailed']);
				}
			}
			
			// Redirect user back to user's bookings page
			return $this->redirect([
				'controller' => 'Users',
				'action' => 'booking'
			]);
		}
		
	}
?>