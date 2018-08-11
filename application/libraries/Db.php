<?php

	class Db
	{
		public $connection;
		public $result;
		public $query;
	
		public function  __construct()
		{	
			global $config;
			$mysql_config = $config['database'];
			
			$this->connection = mysqli_connect($mysql_config['host_name'], $mysql_config['user_name'], $mysql_config['password'] , $mysql_config['database_name'] , $mysql_config['port']);			

			// Check connection
			if (mysqli_connect_errno()) {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();exit;
			}
		}
		
		public function escape($string)
		{
			return mysqli_real_escape_string($this->connection , $string);
		}
		
		public function query($query)
		{	
			Logger::log('query', $query);
			
			$start_time = microtime(true);

			$this->query = $query;
			$this->result = mysqli_query($this->connection , $query);
			
			$end_time = microtime(true);

			Logger::log('query' , "Query Time : ".($end_time - $start_time)."ms | Start Time : ".$start_time." | End Time : ".$end_time."\n");

			if ($this->result)
			{
				return true;
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, ExceptionHandler::$COMMON, array('query' => $this->query));
			}
		}
		
		public function get($tableName , $conditions = array() , $order = array() , $limit = array() , $selectColumns = array())
		{
			$this->select($tableName , $selectColumns , $conditions , $order , $limit);
			$row = $this->get_row();
			
			if(empty($row))
			{
				throw new DBException(DBException::$EX_CODE_DB_RECORD_NOT_FOUND, ExceptionHandler::$COMMON, array('query' => $this->query));
			}
			return $row;
		}
		
		public function gets($tableName , $conditions = array() , $order = array() , $limit = array() , $selectColumns = array())
		{
			$this->select($tableName , $selectColumns , $conditions , $order , $limit);
			return $this->get_rows();		
		}
		
		public function select($tableName , $selectColumns = array(), $conditions = array() , $order = array() , $limit = array())
		{
			$query = 'SELECT ';
			if($selectColumns == NULL || count($selectColumns) == 0)
			{
				$query .= '* ';
			}
			else
			{
				$query .= '`'.implode('`,`', $selectColumns).'` ';
			}
			$query .= ' FROM `' . $tableName . '` ';
	
			$query .= $this->prepare_where($conditions);
			$query .= $this->prepare_order($order);
			$query .= $this->prepare_limit($limit);
			
			return $this->query($query);
			
		}
		public function num_rows()
		{
			if($this->result)
			{
				return mysqli_num_rows($this->result);
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, ExceptionHandler::$COMMON, array('query' => $this->query));
			}
	
		}
		public function get_row()
		{
			if($this->result)
			{
				return mysqli_fetch_assoc($this->result);
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, ExceptionHandler::$COMMON, array('query' => $this->query));
			}
		}
	
		public function get_rows()
		{
			if($this->result)
			{
				$rows = array();
				while($row = mysqli_fetch_assoc($this->result))
				{
					$rows[] = $row;
				}
				return $rows;
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, ExceptionHandler::$COMMON, array('query' => $this->query));
			}
		}
	
		public function insert($tableName , $values)
		{
			Logger::log('db.insert' , $values);
			$columns = array();
			$vals = array();
			foreach($values as $column => $value)
			{
				$columns[] = $column;
				$vals[] = mysqli_real_escape_string($this->connection , $value);
			}
			$query  = '';
			$query .= 'INSERT INTO `'.$tableName.'` ';
			$query .= '(';
			$query .= '`'.implode('`,`' , $columns).'`';
			$query .= ') VALUES (';
			$query .= '"'.implode('","' , $vals).'"';
			$query .= ')';
	
			$result = $this->query($query);
			
			if($result)
			{
				return mysqli_affected_rows($this->connection);
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, ExceptionHandler::$COMMON, array('query' => $this->query));
			}
		}
	
		public function insert_id()
		{
			return mysqli_insert_id($this->connection);
		}
	
		public function update($tableName , $values , $conditions = array() , $order = array() , $limit = array())
		{
			// Logger::log('db.update' , $values);
			$query  = '';
			$query .= 'UPDATE `'.$tableName.'` SET ';
			foreach($values as $column => $value)
			{
				$query .= '`' . $column . '`="'. mysqli_real_escape_string($this->connection , $value) .'" ,';
			}
			$query = substr($query, 0 , strlen($query) - 1);
	
			$query .= $this->prepare_where($conditions);
			$query .= $this->prepare_order($order);
			$query .= $this->prepare_limit($limit);
	
			$result = $this->query($query);
	
			if($result)
			{
				return mysqli_affected_rows($this->connection);
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, ExceptionHandler::$COMMON, array('query' => $this->query));
			}
		}
	
		public function delete($tableName , $conditions = array() , $order = array() , $limit = array())
		{
			$query = '';
			$query .= 'DELETE FROM `' . $tableName . '` ';
			$query .= $this->prepare_where($conditions);
			$query .= $this->prepare_order($order);
			$query .= $this->prepare_limit($limit);
	
			$result = $this->query($query);
	
			if($result)
			{
				return mysqli_affected_rows($this->connection);
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, ExceptionHandler::$COMMON, array('query' => $this->query));
			}
		}
	
		private function prepare_where($conditions)
		{
			$whereStmt = '';
			if($conditions != NULL && is_array($conditions))
			{
				if($conditions != NULL && count($conditions) > 0)
				{
					$andConditions = array();
							
					foreach($conditions as $column => $value)
					{		
						if (is_array($value))
						{
							$andConditions[] = '`' . $column . '` IN ("'.implode('","', $value).'") ';
						}
						else
						{
							$andConditions[] = '`' . $column . '`="'.mysqli_real_escape_string($this->connection , $value).'"';
						}
					}
		
					if(count($andConditions) > 0)
					{
						$whereStmt .= 'WHERE ' . implode(' AND ' , $andConditions);
					}
				}
			}
			else if($conditions != null && strlen(trim($conditions)) > 0)
			{
				$whereStmt .= 'WHERE ' . $conditions;
			}
			
			return $whereStmt;
		}
	
		private function prepare_order($order)
		{
			$orderStmt = ' ';
			if($order == "rand")
			{
				$orderStmt .= 'ORDER BY RAND() ';
			}
			else if($order != NULL && count($order) > 0)
			{
				$orderStmt .= 'ORDER BY ';
				foreach($order as $column => $ord)
				{
					$orderStmt .= '`'.$column.'` '.strtoupper($ord) . ' ,';
				}
				$orderStmt = substr($orderStmt, 0 , strlen($orderStmt) - 1);
			}
			return $orderStmt;
		}
	
		private function prepare_limit($limit)
		{
			$limitStmt = ' ';
			if($limit != NULL && count($limit) > 0)
			{
				$limitStmt .= 'LIMIT ' . $limit[0] . ' , ' . $limit[1];
			}
			return $limitStmt;
		}
	}