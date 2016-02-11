<?php
	class user{

		
		private $_db,
				$_data,
				$_sessionName,
				$_cookieName,
				$_isLoggedIn = false,
				$_log;
				
				
		
		public function __construct($user = null,$log){
			$this->_db = db::getInstance();
			$this->_sessionName = config::get('session/session_name');
			$this->_cookieName = config::get('remember/cookie_name');

			$this->_log = $log;
			
			if(!$user) {
				if(session::exists($this->_sessionName)) {				//if remember cookie is used for login attempt
					$user = session::get($this->_sessionName);
					
					if($this->find($user)) {
						$this->_isLoggedIn = true;
						
					}
					else {
						//logout
					}
				}
				
			}
			else 
			{
				$this->find($user);
			}
		}
		
		public function update($fields = array(),$id = null) {
				
			if(!$id && $this->isLoggedIn()){
				$id = $this->data()->Id;	
			}	
			
			if(!$this->_db->update('Users',$id, $fields)) {
				$this->_log->error('Could not update user: ' . $username); // Will be logged 
				throw new Exception('There was a problem updating! ');
			}
			$this->_log->info('User updated: ' . $username); // Will be logged 
			
		}

		public function updateUser($fields = array(),$username = null) {
				
			
			
			if(!$this->_db->updateUserName('Users',$username, $fields)) {
				$this->_log->error('Could not update user: ' . $username); // Will be logged 
				throw new Exception('There was a problem updating! ');
			}
			$this->_log->info('User updated: ' . $username); // Will be logged 
			
		}
		
		public function create($fields) {
			if(!$this->_db->insert('Users',$fields)) {
				$this->_log->error('Could not create user: ' . $username); // Will be logged 
				throw new Exception('There was a problem creating account.');
			}
			$this->_log->info('User created: ' . $username); // Will be logged 
		}
		
		public function find($user = null) {
			if($user) {
				$field = (is_numeric($user)) ? 'Id' : 'Username';
				if($data = $this->_db->get('Users',array($field,'=',$user)))
				{
				
				if($data->counts()) {
					$this->_data = $data->first();
					
					return true;
				}
			}else
			{
				echo "could not read from database";
			}
			} 
			return false;
			
		}

		public function delete($user = null) {
			if($user) {
				$field = (is_numeric($user)) ? 'Id' : 'Username';
				if($data = $this->_db->delete('Users',array($field,'=',$user)))
				{
				
					//if($data->counts()) {
						//$this->_data = $data->first();
						
						return true;
					//}
				}else
				{
					echo "could not read from database";
				}
			} 
			return false;
			
		}

		public function verified($user = null) {
			if($user) {
				$field = (is_numeric($user)) ? 'Id' : 'Username';
				if($data = $this->_db->get('Users',array($field,'=',$user)))
				{
				
				if($data->counts()) {
					$this->_data = $data->first();
					if($this->_data->User_Verified == 1)
					{
						return true;
					}				
					else
					{
						return false;
					}
				}
			}
			else
			{
					echo "could not read from database";
			}
		} 
			return false;
			
		}
		
		public function login($username = null, $password = null, $remember = false) {
			
			
			if(!$username && !$password && $this->exists()) {  //if no username or password sent to function and there is a user in database, used when remeber function is active
				
				session::put($this->_sessionName,$this->data()->Id);
			}
			else {
				
			$user = $this->find($username);
			
			
			if($user) {
					
				if($this->data()->Password === hash::make($password, $this->data()->Salt)) {
					
					session::put($this->_sessionName, $this->data()->Id);
					
					if($remember) {  //if remeber option selected
						
						$hash = hash::unique();
						$hashCheck = $this->_db->get('User_Sessions', array('User_Id','=',$this->data()->Id));  //check whether user session saved on db
						
						if(!$hashCheck->counts()) {
							$this->_db->insert('User_Sessions',array(  //if not saved, save on session db
								'User_Id' => $this->data()->Id,
								'Hash' => $hash
							
							));
						}
						else {
							$hash = $hashCheck->first()->Hash;  //if already in session db use that hash (should not happen)
						}
						
						cookie::put($this->_cookieName,$hash, config::get('remember/cookie_expiry'));  //create login cookie
						
					}
					
					return true;
					
				}
				else {
					$this->_log->warning('Wrong  password used for user: ' . $username); // Will be logged 
					echo "Sorry, password is incorrect. Please try again. ";
				}
			}
			
			else {
			//	var_dump($logger);
				$this->_log->warning('Wrong username used: '  . $username); // Will be logged 
				echo "Sorry, username not found. ";
			}
			}  //end of not remember
			return false;
			
		}

 //used to determine user permissions as saved on db $key is the permission tested for e.g. admin
		public function hasPermission($key) { 
			$group = $this->_db->get('User_Groups',array('User_Group','=',$this->data()->User_Group));
			
			if($group->counts() > 0) {
				
				$permissions = json_decode($group->first()->Permissions,true);
				
				
				if($permissions[$key] == "true") {
					//echo "ok";
					return true;
				}				
				else {
					//echo "not ok";
					return false;
				}
			}
			
		}
		
		public function exists() {
			return (!empty($this->_data)) ? true : false;
		}
		
		public function logout() {
			$this->_db->delete('User_Sessions',array('User_Id','=',$this->data()->Id));
			session::delete($this->_sessionName);
			cookie::delete($this->_cookieName);
		}
		
		public function data() {
			return $this->_data;
		}
		
		public function isLoggedIn() {
			return $this->_isLoggedIn;
		}
	}

?>