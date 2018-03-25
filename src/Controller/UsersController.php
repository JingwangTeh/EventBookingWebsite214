<?php
	namespace App\Controller;
	use App\Controller\AppController;
	use Cake\Event\Event;
	
	use Cake\ORM\TableRegistry;
	use Cake\Datasource\ConnectionManager;
	use Cake\Auth\DefaultPasswordHasher;
	
	use Cake\I18n\Time;
	
	class UsersController extends AppController {
		
		/*
		 * beforeFilter Function
		 * note: this function is part of the controller's life cycle
		 */
		public function beforeFilter(Event $event){
			// Users who are not logged in can still access the register and logout actions
			$this->Auth->allow(['controller' => 'Users', 'action' => 'register', 'logout']);
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
		 * Register Function
		 */
		public function register(){
			
			/*
			 * If user is already logged in, and
			 * tries to manually access this controller action,
			 * user should be redirected back to user home page
			 */
			if ($this->Auth->user()) {
				return $this->redirect(
					['controller' => 'Users', 'action' => 'Home']
				);
			}
			
			/*
			 * Authenticate user registration information
			 */
			$user = $this->Users->newEntity();
			if($this->request->is('post'))
			{
				// If form is empty
				if (empty($this->request->data('email')) && 
					empty($this->request->data('username')) &&
					empty($this->request->data('password')) &&
					empty($this->request->data('password_confirm')))
				{
					// Display error message
					$this->Flash->error("Please fill in the form.");
				}
				// If passwords do not match
				else if ($this->request->data('password') != $this->request->data('password_confirm'))
				{
					// Display error message
					$this->Flash->error("Please fix the following error:");
					$this->Flash->error('Password does not match.');
				}
				else
				{
					// Set email, username and password based on registration form input
					// Note: Validation & Password hashing is done in UsersEntity & UsersTable
					$user = $this->Users->patchEntity($user, $this->request->getData());
					
					// Register the user
					if ($this->Users->save($user)) {
						//$this->Flash->success(__('The user has been saved.'));
						
						// User auto-login
						$this->Auth->setUser($user->toArray());
						
						// Redirect user to user's home page
						return $this->redirect([
							'controller' => 'Users',
							'action' => 'home'
						]);
					}
					
					// Failed to register user
					if($user->errors()){
						
						// Array to store error messages
						$error_msg = [];
						
						// Get error messages from User Entity
						// Note: User Validation Rules are set in UsersTable
						foreach($user->errors() as $errors){
							if(is_array($errors)){
								foreach($errors as $error){
									$error_msg[] = $error;
								}
							}else{
								$error_msg[] = $errors;
							}
						}

						// If there are error messages
						if(!empty($error_msg)){
							$this->Flash->error("Please fix the following error:");
							
							foreach($error_msg as $errors)
							{
								$this->Flash->error($errors);	
							}
						}
					}
				}
				// End of User Registration
			}
		}
		
		/*
		 * Login Function
		 */
		public function login(){
			
			/*
			 * If user is already logged in, and
			 * tries to manually access this controller action,
			 * user should be redirected back to user home page
			 */
			if ($this->Auth->user()) {
				return $this->redirect(
					['controller' => 'Users', 'action' => 'Home']
				);
			}
			
			/*
			 * Authenticate user login information
			 */
			if($this->request->is('post')){
				
				// If form is empty
				if (empty($this->request->data('username')) && empty($this->request->data('password')))
				{
					$this->Flash->error('Please fill in the username and password.');
				}
				// If username is empty
				else if (empty($this->request->data('username')))
				{
					$this->Flash->error('Please fill in the username.');
				}
				// If password is empty
				else if (empty($this->request->data('password')))
				{
					$this->Flash->error('Please fill in the password.');
				}
				else if (!empty($this->request->data('username')) && !empty($this->request->data('password')))
				{
					// Authenticate user based on login information
					$user = $this->Auth->identify();
					
					// Authentication Success
					if ($user) {
						// Set user information
						$this->Auth->setUser($user);
						// After logging in, redirect the user to the
						// URL, which has been set in AppController's Authentication Component's LoginRedirect config option
						return $this->redirect($this->Auth->redirectUrl());
					}
					// Authentication Failed
					else {
						$this->Flash->error('Your username or password is incorrect.');
					}
				}
				// End of User Login
			}
		}
		
		/*
		 * Logout Function
		 */
		public function logout(){
			$this->Flash->success('You are now logged out.');
			return $this->redirect($this->Auth->logout());
		}

		/*
		 * User Home (Profile Page)
		 */
		public function home(){
			$userID = $this->Auth->user('id');
			$username = $this->Auth->user('username');
			
			// Get user profile information
			$user = TableRegistry::get('sysuser')
										->find()
										->where(['id'=>$userID])
										->first();
			$this->set('userList', $user);
		}
		
		/*
		 * Edit Profile Function
		 */
		public function edit(){
			
			// Get Existing User Entity
			$id = $this->Auth->user('id');
			// Get user profile information to display
			$user = $this->Users->get($id);
			$this->set('user', $user);
			
			
			
			// Update new values after form submission
			if($this->request->is('post')){
				
				$user = $this->Users->patchEntity($user, $this->request->getData());
				
				if ($this->Users->save($user))
				{
					//echo "User is updated";
					$this->Flash->success(__('Your account has been edited'));
					
					$this->Auth->setUser($user);
					
					return $this->redirect(['controller' => 'Users', 'action' => 'edit']);
				}
				else
				{	
					// Failed to update user details
					if($user->errors()){
						
						// Array to store error messages
						$error_msg = [];
						
						// Get error messages from User Entity
						// Note: User Validation Rules are set in UsersTable
						foreach($user->errors() as $errors){
							if(is_array($errors)){
								foreach($errors as $error){
									$error_msg[] = $error;
								}
							}else{
								$error_msg[] = $errors;
							}
						}

						// If there are error messages
						if(!empty($error_msg)){
							$this->Flash->error("Please fix the following error:");
							
							foreach($error_msg as $errors)
							{
								$this->Flash->error($errors);	
							}
						}
					}
				}
				
			}
		}
		
		/*
		 * User Home #2 (List of Events hosted/created by User)
		 */
		public function event(){
			$username = $this->Auth->user('username');
			$userID = $this->Auth->user('id');
			
			// Set paginator settings
			$this -> paginate['limit'] = 5;
			$this -> paginate['order'] = ['event.eventTitle' => 'asc'];
			
			// list of events hosted by user
			$events = TableRegistry::get('event')
											->find()
											->where(['eventHost'=>$username]);
			$this->set('eventList', $this->paginate($events));
		}
		
		/*
		 * User Home #3 (List of Events booked by User)
		 */
		public function booking(){
			$username = $this->Auth->user('username');
			$userID = $this->Auth->user('id');
			
			// Set paginator settings
			$this -> paginate['limit'] = 5;
			$this -> paginate['order'] = ['event.eventTitle' => 'asc'];
			
			// list of events booked by user
			$booking = TableRegistry::get('bookings')
											->find()
											->contain(['events' => function ($q) {
														return $q
															->select(['eventID', 'eventTitle', 'eventStartDate', 'eventLocation', 
																	  'eventStatus', 'eventMarkForDeletion']);
													}
											])
											->where(['userID' => $userID]);
			$this->set('bookingList', $this->paginate($booking));
		}
	}
?>