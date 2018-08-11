<?php

	class MySQLConnector
	{
		private static $instances;

		private $connection;
		private $result;
		private $query;

		public function  __construct($config = array())
		{
			if(!empty($config))
			{
				Logger::log('query.mysql', '-------------------- Connection Start -----------------------');
				Logger::log('query.mysql', $config);

				$this->connection = mysqli_connect($config['hostname'], $config['username'], $config['password'] , $config['database'] , $config['port']);
			}
		}

		public static function get_instance($config)
		{
			$instance_key = $config['hostname'].':'.$config['username'].':'.$config['database'];
			$instance = self::$instances[$instance_key];
			if(!$instance)
			{
				$instance = new MySQLConnector($config);
				self::$instances[$instance_key] = $instance;
			}
			return $instance;
		}

		public function connect_datasource($anant_datasource)
		{
			return $this->get_instance($anant_datasource->toArray());
		}

		public function query($query)
		{
			$this->query = $query;
			$this->result = mysqli_query($this->connection , $query);

			Logger::log('query.mysql', $query);

			if ($this->result)
			{
				Logger::log('query.mysql', 'Success');
				Logger::log('query.mysql', $this->result);
				return true;
			}
			else
			{
				Logger::log('query.mysql', 'Error');
				Logger::log('query.mysql', $this->query);
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
			}
		}

		public function get($table_name , $conditions = array() , $order = array() , $limit = array())
		{
			$this->select($table_name , array() , $conditions , $order , $limit);
			$row = $this->get_row();

			if(empty($row))
			{
				return false;
			}
			return $row;
		}

		public function gets($table_name , $conditions = array() , $order = array() , $limit = array())
		{
			$this->select($table_name , array() , $conditions , $order , $limit);
			return $this->get_rows();
		}

		public function select($table_name , $columns = array(), $conditions = array() , $order = array() , $limit = array())
		{
			Logger::log('query.mysql', '-----------------------------');
			Logger::log('query.mysql', 'Query in : '.$table_name);
			Logger::log('query.mysql', $columns);
			Logger::log('query.mysql', $conditions);
			Logger::log('query.mysql', $order);
			Logger::log('query.mysql', $limit);


			$query = 'SELECT ';
			if($columns == NULL || count($columns) == 0)
			{
				$query .= '* ';
			}
			else
			{
				$query .= implode(',', $columns).' ';
			}
			$query .= ' FROM `' . $table_name . '` ';

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
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
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
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
			}
		}

		public function get_index_row()
		{
			if($this->result)
			{
				return mysqli_fetch_array($this->result);
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
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
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
			}
		}

		public function get_index_rows()
		{
			if($this->result)
			{
				$rows = array();
				while($row = mysqli_fetch_array($this->result))
				{
					$rows[] = $row;
				}
				return $rows;
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
			}
		}

		public function insert($table_name , $record)
		{
			Logger::log('query.mysql', '-----------------------------');
			Logger::log('query.mysql', 'Insert Record in : '.$table_name);
			Logger::log('query.mysql', $record);

			$columns = array();
			$vals = array();
			foreach($record as $column => $value)
			{
				$columns[] = $column;
				$val = mysqli_real_escape_string($this->connection , $value);
				$vals[] = $val;
				Logger::log('query.mysql', $column . ':' .$value . ':' .$val);
			}
			Logger::log('query.mysql', $columns);
			Logger::log('query.mysql', $vals);

			$query  = '';
			$query .= 'INSERT INTO `'.$table_name.'` ';
			$query .= '(';
			$query .= '`'.implode('`,`' , $columns).'`';
			$query .= ') VALUES (';
			$query .= '"'.implode('","' , $vals).'"';
			$query .= ')';
			Logger::log('query.mysql', $query);

			$result = $this->query($query);
			Logger::log('query.mysql', '-----------------------------');
			if($result)
			{
				return mysqli_affected_rows($this->connection);
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
			}
		}

		public function insert_batch($table_name , $records)
		{
			Logger::log('query.mysql', '-----------------------------');
			Logger::log('query.mysql', 'Insert Batch Records : '.$table_name);
			Logger::log('query.mysql', $records);

			foreach ($records as $record)
			{
				$this->insert($table_name , $record);
			}
			Logger::log('query.mysql', '-----------------------------');
		}

		public function insert_id()
		{
			return mysqli_insert_id($this->connection);
		}

		public function update($table_name , $record , $conditions = array() , $order = array() , $limit = array())
		{
			$query  = '';
			$query .= 'UPDATE `'.$table_name.'` SET ';
			foreach($record as $column => $value)
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
				$updates = mysqli_affected_rows($this->connection);

				if($updates == 0)
				{
					// throw new DBException(DBException::$EX_CODE_NO_UPDATE , "" , $this->query);
				}

				return $updates;
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
			}
		}

		public function delete($table_name , $conditions = array() , $order = array() , $limit = array())
		{
			$query = '';
			$query .= 'DELETE FROM `' . $table_name . '` ';
			$query .= $this->prepare_where($conditions);
			$query .= $this->prepare_order($order);
			$query .= $this->prepare_limit($limit);

			$result = $this->query($query);

			if($result)
			{
				$updates =  mysqli_affected_rows($this->connection);

				if($updates == 0)
				{
					// throw new DBException(DBException::$EX_CODE_NO_UPDATE , "" , $this->query);
				}

				return $updates;
			}
			else
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, "", $this->query);
			}
		}

		/*
		private function prepare_where($conditions)
		{
			$whereStmt = '';
			$wheres = array();

			foreach ($conditions as $key => $conds)
			{
				if($key == 'OR')
				{
					$orStmt = '';

					$ors = array();
					foreach ($conds as $col => $cons)
					{
						$ands = array();
						foreach ($cons as $column => $value)
						{
							$ands[] = $this->prepare_condition($column , $value);
						}

						if(count($ands) > 0)
						{
							$ors[] = '('.implode(' AND ' , $ands).')';
						}
					}
					if(count($ors) > 0)
					{
						$wheres[] = '('.implode(' OR ' , $ors).')';
					}
				}
				else
				{
					$wheres[] = $this->prepare_condition($key , $conds);
				}
			}

			if(count($wheres) > 0)
			{
				$whereStmt = 'WHERE ' . implode(' AND ' , $wheres);
			}

			return $whereStmt;
		}
		/**/

		private function prepare_where($conditions)
		{
			/*
			if(isset($conditions['OR']))
			{
				$columns = $conditions['OR'];
				$where_stmt = $this->prepare_where_or($columns);
			}
			else if(isset($conditions['AND']))
			{
				$columns = $conditions['AND'];
				$where_stmt = $this->prepare_where_and($columns);
			}
			else
			{
				$columns = $conditions;
				$where_stmt = $this->prepare_where_and($columns);
			}
			/**/

			$columns = $conditions;
			$where_stmt = $this->prepare_where_and($columns);

			if(strlen($where_stmt))
			{
				$where_stmt = 'WHERE ' . $where_stmt;
			}

			Logger::log('query.mysql', '			Where prepared: ' . $where_stmt);

			return $where_stmt;
		}

		private function prepare_where_and_list($list)
		{
			$ands = array();
			for($i = 0 ; $i < count($list) ; $i ++)
			{
				$ands[] = $this->prepare_where_and($list[$i]);
			}
			$ands = array_filter($ands);

			$and_stmt = '';
			if(count($ands) > 0)
			{
				$and_stmt = '('.implode(' AND ' , $ands).')';
			}

			return $and_stmt;
		}

		private function prepare_where_and($columns)
		{
			Logger::log('query.where' , '------ AND : START ----------');
			Logger::log('query.where' , $columns);

			$and_stmt = '';
			$ands = array();

			foreach ($columns as $column => $value)
			{
				if($column == 'AND')
				{
					$ands[] = $this->prepare_where_and_list($value);
				}
				else if($column == 'OR')
				{
					$ands[] = $this->prepare_where_or_list($value);
				}
				else
				{
					$ands[] = $this->prepare_condition($column , $value);
				}
			}
			$ands = array_filter($ands);

			if(count($ands) > 0)
			{
				$and_stmt = '('.implode(' AND ' , $ands).')';
			}

			Logger::log('query.where' , $ands);
			Logger::log('query.where' , $and_stmt);
			Logger::log('query.where' , '------ AND : END ----------');

			return $and_stmt;
		}

		private function prepare_where_or_list($list)
		{
			$ors = array();
			for($i = 0 ; $i < count($list) ; $i ++)
			{
				$ors[] = $this->prepare_where_or($list[$i]);
			}
			$ors = array_filter($ors);

			$or_stmt = '';
			if(count($ors) > 0)
			{
				$or_stmt = '('.implode(' OR ' , $ors).')';
			}

			return $or_stmt;
		}

		private function prepare_where_or($columns)
		{
			Logger::log('query.where' , '------ OR : START ----------');
			Logger::log('query.where' , $columns);

			$or_stmt = '';
			$ors = array();

			foreach ($columns as $column => $value)
			{
				if($column == 'AND')
				{
					$ors[] = $this->prepare_where_and_list($value);
				}
				else if($column == 'OR')
				{
					$ors[] = $this->prepare_where_or_list($value);
				}
				else
				{
					$ors[] = $this->prepare_condition($column , $value);
				}
			}

			$ors = array_filter($ors);


			if(count($ors) > 0)
			{
				$or_stmt = '('.implode(' OR ' , $ors).')';
			}

			Logger::log('query.where' , $ors);
			Logger::log('query.where' , $or_stmt);
			Logger::log('query.where' , '------ OR : END ----------');

			return $or_stmt;
		}

		private function prepare_condition($column , $value)
		{
			// Logger::log('query.where' , '------ Condition ----------');
			// Logger::log('query.where' , $column);
			// Logger::log('query.where' , $value);

			if(isset($value['operator']))
			{
				$operator = $value['operator'];
				$val = $value['value'];
				$case_sensitive = isset($value['case_sensitive']) ? $value['case_sensitive'] : true;

				// TODO : Implement case insensitivity

				switch($operator)
				{
					case 'IS':
						return '`' . $column . '` = "'.mysqli_real_escape_string($this->connection , $val).'"';
					case 'GT':
						return '`' . $column . '` > "'.mysqli_real_escape_string($this->connection , $val).'"';
					case 'GTE':
						return '`' . $column . '` >= "'.mysqli_real_escape_string($this->connection , $val).'"';
					case 'IN':
						// if(count($val) > 0)
						return '`' . $column . '` IN ("'.implode('","', $val).'") ';
						// else
						// 	return '';
					case 'NIN':
						if(count($val) > 0)
							return '`' . $column . '` NOT IN ("'.implode('","', $val).'") ';
						else
							return '';
					case 'LT':
						return '`' . $column . '` < "'.mysqli_real_escape_string($this->connection , $val).'"';
					case 'LTE':
						return '`' . $column . '` <= "'.mysqli_real_escape_string($this->connection , $val).'"';
					case 'NE':
						return '`' . $column . '` != "'.mysqli_real_escape_string($this->connection , $val).'"';
					case 'LIKE':
						return '`' . $column . '` LIKE "%'.mysqli_real_escape_string($this->connection , $val).'%"';
					case 'LENGTH':
						return 'LENGTH(`' . $column . '`) = "'.mysqli_real_escape_string($this->connection , $val).'"';
					default :
						throw new DBException(DBException::$EX_CODE_INVALID_OPERATOR);
				}
			}
			else if(is_array($value))
			{
				// if(count($value) > 0)
				return '`' . $column . '` IN ("'.implode('","', $value).'") ';
				// else
				// 	return '';
			}
			else
			{
				return '`' . $column . '` = "'.mysqli_real_escape_string($this->connection , $value).'"';
			}
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
					$ord = $ord ? 'ASC' : 'DESC';
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
