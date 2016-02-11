
<?php
	class db{
		
		private static $_instance = null;
		private $_pdo, 
				$_query, 
				$_error = false, 
				$_results, 
				$_count = 0;
				
		private function __construct()
		{
			try{
//$this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . 'dbname=' . config::get('mysql/db'),
				//					config::get('mysql/username'),config::get('mysql/Password'));

				$this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/db'),
									config::get('mysql/username'),config::get('mysql/password'));
								
			} catch(PDOException $e){
				
				die($e->getMessage());			
			}
			
		}
		
		public static function getInstance()
		{
			if(!isset(self::$_instance)) {
				self::$_instance = new db();
			}
			return self::$_instance;
			
		}
		
		
		public function query($sql, $params = array()){
			$this->_error = false;
			
			if($this->_query = $this->_pdo->prepare($sql)) {
				
				$x = 1;
				if(count($params)){
					
					foreach ($params as $param) {
						$this->_query->bindValue($x,$param);
						$x++;				
					}
					
					if($this->_query->execute()){
						
						$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
						$this->_count = $this->_query->rowCount();
						
					}
					else {
						
					 $this->_error = true;	
						
					}
				}
					
			}
			return $this;
		}
		
		
		public function action($action, $table, $where = array(), $where2 = array() ){
			
			
			//if(!count($where2)){

			if(count($where) === 3){
				$operators = array('IS NOT','IS','=', '>', '<','>=','<=','<>','LIKE');
				
				$field 	= $where[0];
				$operator = $where[1];
				$value = $where[2];
				
				if(in_array($operator, $operators)){
					
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				//	var_dump($sql);
					if(!$this->query($sql, array($value))->error()) {
						
						return $this;
						
					}
					
					
				}
				
			}

			if(count($where) === 0) {
				
				
					
					$sql = "{$action} FROM {$table} ";
					
					if(!$this->query($sql, array(null))->error()) {
						
						return $this;
						
					}
					
					
				
			}
			if(count($where) === 6){
				$operators = array('IS NOT','IS','=', '>', '<','>=','<=','<>','LIKE');
				
				$field 	= $where[0];
				$operator = $where[1];
				$value = $where[2];
				$field2 	= $where[3];
				$operator2 = $where[4];
				$value2 = $where[5];
				
				if(in_array($operator, $operators)){
					
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field2} {$operator2} ?";
					
					if(!$this->query($sql, array($value,$value2))->error()) {
						
						return $this;
						
					}
					
					
				}
				
			}
			if(count($where) === 9){
				$operators = array('IS NOT','IS','=', '>', '<','>=','<=','<>','LIKE');
				
				$field 	= $where[0];
				$operator = $where[1];
				$value = $where[2];
				$field2 	= $where[3];
				$operator2 = $where[4];
				$value2 = $where[5];
				$field3 	= $where[6];
				$operator3 = $where[7];
				$value3 = $where[8];
				
				if(in_array($operator, $operators)){
					
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field2} {$operator2} ? AND {$field3} {$operator3} ?";
					
					if(!$this->query($sql, array($value,$value2,$value3))->error()) {
						
						return $this;
						
					}
					
					
				}
				
			}
			if(count($where) === 12){
				$operators = array('IS NOT','IS','=', '>', '<','>=','<=','<>','LIKE');
				
				$field 	= $where[0];
				$operator = $where[1];
				$value = $where[2];
				$field2 	= $where[3];
				$operator2 = $where[4];
				$value2 = $where[5];
				$field3 	= $where[6];
				$operator3 = $where[7];
				$value3 = $where[8];
				$field4 	= $where[9];
				$operator4 = $where[10];
				$value4 = $where[11];
				
				if(in_array($operator, $operators)){
					
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field2} {$operator2} ? AND {$field3} {$operator3} ? AND {$field4} {$operator4} ?";
					
					if(!$this->query($sql, array($value,$value2,$value3,$value4))->error()) {
						
						return $this;
						
					}
					
					
				}
				
			}
			
			if(count($where) === 15){
				$operators = array('IS NOT','IS','=', '>', '<','>=','<=','<>','LIKE');
			
				$field 	= $where[0];
				$operator = $where[1];
				$value = $where[2];
				$field2 	= $where[3];
				$operator2 = $where[4];
				$value2 = $where[5];
				$field3 	= $where[6];
				$operator3 = $where[7];
				$value3 = $where[8];
				$field4 	= $where[9];
				$operator4 = $where[10];
				$value4 = $where[11];
				$field5 	= $where[12];
				$operator5 = $where[13];
				$value5 = $where[14];
			
				if(in_array($operator, $operators)){
						
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field2} {$operator2} ? AND {$field3} {$operator3} ? AND {$field4} {$operator4} ? AND {$field5} {$operator5} ?";
						
					if(!$this->query($sql, array($value,$value2,$value3,$value4,$value5))->error()) {
			
						return $this;
			
					}
						
						
				}
			
			}
		//}else
		//{
			if(count($where2)){
			if(count($where) === 3 && count($where2) === 3){
				$operators = array('IS NOT','IS','=', '>', '<','>=','<=','<>','LIKE');
				
				$field 	= $where[0];
				$operator = $where[1];
				$value = $where[2];

				$fieldOR 	= $where2[0];
				$operatorOR = $where2[1];
				$valueOR = $where2[2];
				
				if(in_array($operator, $operators)){
					
					$sql = "{$action} FROM {$table} WHERE ({$field} {$operator} ?) OR ($fieldOR} {$operatorOR} ?)";
				//	var_dump($sql);
					if(!$this->query($sql, array($value,$valueOR))->error()) {
						
						return $this;
						
					}
					
					
				}
				
			}
			
			if(count($where) === 6 && count($where2) === 3){
				$operators = array('IS NOT','IS','=', '>', '<','>=','<=','<>','LIKE');
				
				$field 	= $where[0];
				$operator = $where[1];
				$value = $where[2];
				$field2 	= $where[3];
				$operator2 = $where[4];
				$value2 = $where[5];

				$fieldOR 	= $where2[0];
				$operatorOR = $where2[1];
				$valueOR = $where2[2];
				
				if(in_array($operator, $operators)){
					
					$sql = "{$action} FROM {$table} WHERE ({$field} {$operator} ? AND {$field2} {$operator2} ?) OR ($fieldOR} {$operatorOR} ?)";
					
					if(!$this->query($sql, array($value,$value2,$valueOR))->error()) {
						
						return $this;
						
					}
					
					
				}
				
			}
		}

		//}
			
			return false;
		}
		
		public function get($table,$where){
			
			return $this->action('SELECT *', $table, $where,array(null));			
			
		}

		public function get2($table,$where1,$where2){


			
			return $this->action('SELECT *', $table, $where1,$where2);			
			
		}


		public function getinnerjoin2($select,$table1,$table2,$join1,$join2,$where){



			if(count($where) === 3){
				$operators = array('IS NOT','IS','=', '>', '<','>=','<=','<>','LIKE');
				
				$field 	= $where[0];
				$operator = $where[1];
				$value = $where[2];
				
				if(in_array($operator, $operators)){
					
					$sql = "Select {$select} FROM {$table1} INNER JOIN {$table2} ON {$join1} = {$join2} WHERE {$field} {$operator} ?  ";
			
					if(!$this->query($sql, array($value))->error()) {
								
						return $this;
						
					}
					
					
				}
				
			}

			if(count($where) === 0) {
				
				
					
				$sql = "Select * FROM {$table1} INNER JOIN {$table2} ON {$join1} = {$join2} ";
			
				if(!$this->query($sql, array($value))->error()) {
							
					return $this;
					
				}
					
					
				
			}

			
			
		}

		
		
		public function delete($table, $where){
			
			return $this->action('DELETE', $table, $where);			
			
		}
		
		
		
		public function insert($table, $fields = array())
		{
			if(count($fields)){
				
				$keys = array_keys($fields);
				$values = '';
				$x = 1;
				
				foreach($fields as $field){
					$values .= '?';
					
					if($x < count($fields)) {
						$values .= ', ';
						
					}
					
					$x++;
					
				}
				
					
				$sql = "INSERT INTO {$table} (" . implode(", ", $keys) . ") VALUES ({$values})";
				
				
				if(!$this->query($sql,$fields)->error()){
					return true;
										
				}
				
			}
			return false;
			
			
		}
		
		public function update($table, $id, $fields){   //$user = db::getInstance(); 
														//$user->update('Users', 2, array('Password' => 'test2','Salt' => 'salt2'));
														//remember id field
			$set = '';
			$x = 1;
			
			foreach($fields as $name => $value){
				
				$set .= "{$name} = ?";
				
				if($x < count($fields)){
					
					$set .= ', ';
				}
				
				$x++;
			}
			
			
			$sql = "UPDATE {$table} SET {$set} WHERE Id = {$id}";
			
			if(!$this->query($sql,$fields)->error()){
					return true;
										
				}
				
			
			return false;
			
		}

		public function updateByStockCode($table, $eventid, $stockcode, $fields){   //$user = db::getInstance(); 
														//$user->update('Users', 2, array('Password' => 'test2','Salt' => 'salt2'));
														//remember id field
		

			$set = '';
			$x = 1;
			
			foreach($fields as $name => $value){
				
				$set .= "{$name} = ?";
				
				if($x < count($fields)){
					
					$set .= ', ';
				}
				
				$x++;
			}
			
			
			$sql = "UPDATE {$table} SET {$set} WHERE Stock_Code = '{$stockcode}' AND Event_Req_Id = {$eventid}";
			
			if(!$this->query($sql,$fields)->error()){
					return true;
										
				}
				
			
			return false;
			
		}

		public function updateUnit($table, $id, $fields){   //$user = db::getInstance(); 
														//$user->update('Users', 2, array('Password' => 'test2','Salt' => 'salt2'));
														//remember id field
			$set = '';
			$x = 1;
			
			foreach($fields as $name => $value){
				
				$set .= "{$name} = ?";
				
				if($x < count($fields)){
					
					$set .= ', ';
				}
				
				$x++;
			}
			
			
			$sql = "UPDATE {$table} SET {$set} WHERE Unit_Id = {$id}";
			
			if(!$this->query($sql,$fields)->error()){
					return true;
										
			}
				
			
			return false;
			
		}

			public function updateUser($table, $id, $fields){   //$user = db::getInstance(); 
														//$user->update('Users', 2, array('Password' => 'test2','Salt' => 'salt2'));
														//remember id field
			$set = '';
			$x = 1;
			
			foreach($fields as $name => $value){
				
				$set .= "{$name} = ?";
				
				if($x < count($fields)){
					
					$set .= ', ';
				}
				
				$x++;
			}
			
			
			$sql = "UPDATE {$table} SET {$set} WHERE User_Id = {$id}";
			
			if(!$this->query($sql,$fields)->error()){
					return true;
										
			}
				
			
			return false;
			
		}

		public function updateUserName($table, $username, $fields){   //$user = db::getInstance(); 
														//$user->update('Users', 2, array('Password' => 'test2','Salt' => 'salt2'));
														//remember id field
			$set = '';
			$x = 1;
			
			foreach($fields as $name => $value){
				
				$set .= "{$name} = ?";
				
				if($x < count($fields)){
					
					$set .= ', ';
				}
				
				$x++;
			}
			
			
			$sql = "UPDATE {$table} SET {$set} WHERE Username = '{$username}'";
			//var_dump($sql);
			if(!$this->query($sql,$fields)->error()){
					return true;
										
			}
				
			
			return false;
			
		}


		public function countIdDate($table){   //$user = db::getInstance(); 
														//$user->update('Users', 2, array('Password' => 'test2','Salt' => 'salt2'));
														//remember id field
			
			
			$sql = "SELECT DATE(Operation_Date) Date , COUNT(Id) totalCount FROM {$table} GROUP BY DATE(Operation_Date)";
			//var_dump($sql);
			if(!$this->query($sql,array(null))->error()){
					return $this;
										
			}
				
			
			return false;

			/*$set = '';
			$x = 1;
			
			foreach($fields as $name => $value){
				
				$set .= "{$name} = ?";
				
				if($x < count($fields)){
					
					$set .= ', ';
				}
				
				$x++;
			}
			*/
			
		}

		public function countIdDoctor($table){   //$user = db::getInstance(); 
														//$user->update('Users', 2, array('Password' => 'test2','Salt' => 'salt2'));
														//remember id field
			
			
			$sql = "SELECT Doctor, COUNT(Doctor) totalCount FROM {$table} GROUP BY Doctor";
			//var_dump($sql);


			if(!$this->query($sql,array(null))->error()){
					return $this;
										
			}
				
			
			return false;

			
			
		}


		public function results(){
			
			return $this->_results;			
			
		}

		public function first(){
			
			return $this->_results[0];			
			
		}

		public function last(){
			
			return $this->_results[sizeof($this->_results)-1];			
			
		}
		
		public function error(){
			
			return $this->_error;
			
		} 
		
		public function counts() {
			
			return $this->_count;
		} 
					
		
	}


?>