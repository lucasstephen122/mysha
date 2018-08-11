<?php
	class MongoConnector
	{
		private static $instances;

		private $database_name;
		private $connection;
		private $result;
		private $upsert_result;
		private $query;
	
		public function  __construct($config = array())
		{	
			if(!empty($config) && is_array($config))
			{
				$this->connect($config);	
			}

			/*
			MongoLog::setModule(MongoLog::ALL);
			MongoLog::setLevel(MongoLog::ALL);
			MongoLog::setCallback('print_mongo_log');
			function print_mongo_log($a, $b, $c) { echo $c; echo "<br/>"; }
			/**/
		}

		public function connect($config , $tries = 6)
		{
			Logger::log('query.mongo' , '----------  Connecting : Start -----------');
			Logger::log('connect.mongo' , '----------  Connecting : Start -----------');
			try
			{
				
				$MongoClient = class_exists('MongoClient' , false) ? 'MongoClient' : 'Mongo';
				Logger::log('query.mongo' , 'Mongo Client Class : '.$MongoClient);
				Logger::log('connect.mongo' , 'Mongo Client Class : '.$MongoClient);
				Logger::log('query.mongo' , $config);
				Logger::log('connect.mongo' , $config);
				Logger::log('query.mongo' , "mongodb://".$config['hostname'].":".$config['port']);
				Logger::log('connect.mongo' , "mongodb://".$config['hostname'].":".$config['port']);
				$connection = new $MongoClient("mongodb://".$config['hostname'].":".$config['port'] , array('connectTimeoutMS' => 1000));
				$this->database_name = $config['database'];
				Logger::log('query.mongo' , "Database : ".$config['database']);
				Logger::log('connect.mongo' , "Database : ".$config['database']);
				$this->connection = $connection->$config['database'];
				Logger::log('query.mongo' , '----------  Connecting : End -----------');
				Logger::log('connect.mongo' , '----------  Connecting : End -----------');
			}
			catch(Exception $e)
			{
				Logger::log('query.mongo' , '	**********  Connecting : ERROR *********** ');
				Logger::log('query.mongo' , '	Left tries : '.$tries);
				if($tries < 0)
				{
					Logger::log('query.mongo' , '	Already tried enough ');	
					throw $e;
				}
				Logger::log('query.mongo' , '	Trying to reconnect...');	
				usleep(500000);
				$this->connect($config , -- $tries);
			}
		}

		public static function get_instance($config)
		{
			$instance_key = $config['hostname'].':'.$config['port'].':'.$config['database'];
			if(isset(self::$instances[$instance_key]))
			{
				return self::$instances[$instance_key];
			}
			else 
			{
				$instance = new MongoConnector($config);
				self::$instances[$instance_key] = $instance;
				return $instance;
			}
		}	

		public function connect_datasource($anant_datasource)
		{
			return $this->get_instance($anant_datasource->toArray());
		}

		public function drop()
		{
			return $this->command(array("dropDatabase" => 1));
		}

		public function drop_collection($tbl_name)
		{
			return $this->connection->$tbl_name->drop();
		}

		public static function clone_collection($from_config , $from_instance , $from_collection , $to_config , $to_instance , $to_collection , $criteria = array() , $fields = array())
		{
			Logger::log('clone.mongo' , 'From Config');			
			Logger::log('clone.mongo' , $from_config);			
			Logger::log('clone.mongo' , 'From Collection');			
			Logger::log('clone.mongo' , $from_collection);			
			Logger::log('clone.mongo' , 'To Config');			
			Logger::log('clone.mongo' , $to_config);			
			Logger::log('clone.mongo' , 'To Collection');			
			Logger::log('clone.mongo' , $to_collection);			
			Logger::log('clone.mongo' , 'Criteria');			
			Logger::log('clone.mongo' , $criteria);			
			Logger::log('clone.mongo' , 'Fields');			
			Logger::log('clone.mongo' , $fields);

			if($from_config['hostname'] == $to_config['hostname'])
			{	
				$query = array();
				foreach ($criteria as $column => $value) 
				{
					if(!is_string($value))
					{
						$query[] = 'this.'.$column.' == '.$value;
					}
					else 
					{
						$query[] = 'this.'.$column.' == "'.$value.'"';	
					}
				}
				$query = implode(' && ', $query);

				$where = "";
				if(strlen($query) > 0)
				{
					$where = '{ $where: \''.$query.'\'} ';
				}

				$fields_str = "";
				foreach ($fields as $key => $value) 
				{
					if(is_string($value))
						$value = '"'.$value.'"';
					$fields_str .= "d.".$key .'='.$value.';';
				}

				$statement = 'db.'.$from_collection.'.find('.$where.').forEach(function(d){ '.$fields_str.' db.getSiblingDB("'.$to_instance->database_name.'")["'.$to_collection.'"].insert(d); });';
				Logger::log('clone.mongo' , $statement);			
				$from_instance->connection->execute($statement);
			}
			else 
			{
				$rows = $from_instance->gets($from_collection , $query);
				if(count($fields) > 0)
				{
					for ($i = 0; $i < count($rows) ; $i++) 
					{ 
						foreach ($fields as $key => $value) 
						{
							$rows[$i][$key] = $value;	
						}
					}
				}
				if(count($rows) > 0)
				{
					$to_instance->insert_batch($to_collection , $rows);
				}
			}
		}

		public function execute($command)
		{
			$this->result = $this->connection->execute($command);
			return isset($this->result['values']) ? $this->result['values'] : true;
		}

		public function command($command)
		{
			$this->result = $this->connection->command($command);
			return isset($this->result['values']) ? $this->result['values'] : true;
		}

		public function get($table_name , $conditions = array() , $order = array() , $limit = array())
		{
			$this->select($table_name , array() , $conditions , $order , $limit);
			$row = $this->get_row();
			
			if(empty($row))
			{
				throw new DBException(DBException::$EX_CODE_NOT_FOUND, $conditions);
			}
			return $row;
		}

		public function gets($table_name , $conditions = array() , $order = array() , $limit = array())
		{
			$this->select($table_name , array() , $conditions , $order , $limit);
			return $this->get_rows();	
		}

		public function select($table_name , $columns = array() , $conditions = array() , $order = array() , $limit = array())
		{
			try 
			{
				Logger::log('query.mongo' , '-----------------------');
				Logger::log('query.mongo' , 'Select Query');
				Logger::log('query.mongo' , 'Database name : '.$this->database_name);
				Logger::log('query.mongo' , 'Table name : '.$table_name);
				Logger::log('query.mongo' , 'Columns');
				Logger::log('query.mongo' , $columns);
				Logger::log('query.mongo' , 'Conditions');
				Logger::log('query.mongo' , $conditions);
				Logger::log('query.mongo' , 'Order');
				Logger::log('query.mongo' , $order);
				Logger::log('query.mongo' , 'Limit');
				Logger::log('query.mongo' , $limit);

				$_columns = array();
				if($columns == NULL || count($columns) == 0)
				{
					$_columns = array();
				}
				else
				{
					foreach ($columns as $column) 
					{
						$_columns[$column] = 1;
					}
				}
				Logger::log('query.mongo' , 'Prepared Columns');
				Logger::log('query.mongo' , $_columns);
				
				$mongo_conditions = $this->prepare_where($conditions);
				Logger::log('query.mongo' , 'Prepared Condition');
				Logger::log('query.mongo' , $mongo_conditions);
				Logger::log('query.mongo' , json_encode($mongo_conditions));
				
				$_order = $this->prepare_order($order);
				Logger::log('query.mongo' , 'Prepared Order');
				Logger::log('query.mongo' , $_order);
				Logger::log('query.mongo' , json_encode($_order));

				if(empty($limit))
				{
					$this->result = $this->connection->$table_name->find($mongo_conditions , $_columns)->sort($_order);	
				}
				else 
				{
					$this->result = $this->connection->$table_name->find($mongo_conditions , $_columns)->sort($_order)->limit($limit[1])->skip($limit[0]);
				}

			}
			catch (Exception $e)
			{
				Logger::log('query.mongo' , 'Query failed');
				throw $e;
			}
			Logger::log('query.mongo' , 'Successfull query');
			Logger::log('query.mongo' , $this->result);
		}


		public function aggregate($table_name , $aggregate_column , $aggregate_operator , $conditions = array() , $order = array() , $limit = array())
		{
			try 
			{
				Logger::log('query.mongo' , '-----------------------');
				Logger::log('query.mongo' , 'Aggregate Query');
				Logger::log('query.mongo' , 'Database name : '.$this->database_name);
				Logger::log('query.mongo' , 'Table name : '.$table_name);
				Logger::log('query.mongo' , 'Aggregate Columns : '.$aggregate_column);
				Logger::log('query.mongo' , 'Aggregate Operator : '.$aggregate_operator);
				Logger::log('query.mongo' , 'Conditions');
				Logger::log('query.mongo' , $conditions);
				Logger::log('query.mongo' , 'Order');
				Logger::log('query.mongo' , $order);
				Logger::log('query.mongo' , 'Limit');
				Logger::log('query.mongo' , $limit);

				
				$mongo_conditions = $this->prepare_where($conditions);
				Logger::log('query.mongo' , 'Prepared Condition');
				Logger::log('query.mongo' , $mongo_conditions);
				Logger::log('query.mongo' , json_encode($mongo_conditions));
				
				$_order = $this->prepare_order($order);
				Logger::log('query.mongo' , 'Prepared Order');
				Logger::log('query.mongo' , $_order);
				Logger::log('query.mongo' , json_encode($_order));

				Logger::log('query.mongo.aggregate' , 'Aggregate');
				Logger::log('query.mongo' , $aggregate_column);
				Logger::log('query.mongo' , $aggregate_operator);

				$result = null;
				switch ($aggregate_operator) 
				{
					case 'MAX':
						$_order = $this->prepare_order(array($aggregate_column => Criteria::$SORT_DESC));
						$this->result = $this->connection->$table_name->find($mongo_conditions , array($aggregate_column => 1))->sort($_order)->limit(1)->skip(0);
						if($this->result->count() > 0)
						{
							$row = $this->get_row();
							$result = $row[$aggregate_column];
							Logger::log('query.mongo' , $row);
							Logger::log('query.mongo' , $result);
						}						
						break;
					case 'MIN':
						$_order = $this->prepare_order(array($aggregate_column => Criteria::$SORT_ASC));
						$this->result = $this->connection->$table_name->find($mongo_conditions , array($aggregate_column => 1))->sort($_order)->limit(1)->skip(0);
						if($this->result->count() > 0)
						{
							$row = $this->get_row();
							$result = $row[$aggregate_column];
							Logger::log('query.mongo' , $row);
							Logger::log('query.mongo' , $result);
						}
						break;
					case 'SUM':
						$command_result = $this->connection->command(array
						(
							'aggregate' => $table_name,
							'pipeline'  => array
							(
								array('$match' => $mongo_conditions),
								array('$group'  => array
								(
									'_id'       => array(),
									'count'     => array('$sum' => 1),
									'sum'  		=> array('$sum' => '$'.$aggregate_column)
								))
    						),
						));
						$result = $command_result['result'][0]['sum'];
						Logger::log('query.mongo' , $command_result);
						Logger::log('query.mongo' , $result);
						break;	
					case 'AVG':
						$command_result = $this->connection->command(array
						(
							'aggregate' => $table_name,
							'pipeline'  => array
							(
								array('$match' => $mongo_conditions),
								array('$group'  => array
								(
									'_id'       => array(),
									'count'     => array('$sum' => 1),
									'avg'  		=> array('$avg' => '$'.$aggregate_column)
								))
    						),
						));
						$result = $command_result['result'][0]['avg'];
						Logger::log('query.mongo' , $command_result);
						Logger::log('query.mongo' , $result);
						break;	
					case 'COUNT':
						$command_result = $this->connection->command(array
						(
							'aggregate' => $table_name,
							'pipeline'  => array
							(
								array('$match' => $mongo_conditions),
								array('$group'  => array
								(
									'_id'       => array(),
									'count'     => array('$sum' => 1),
								))
    						),
						));
						$result = $command_result['result'][0]['count'];
						Logger::log('query.mongo' , $command_result);
						Logger::log('query.mongo' , $result);
						break;	
					default:
						break;
				}				
			}
			catch (Exception $e)
			{
				Logger::log('query.mongo' , 'Query failed');
				throw $e;
			}
			Logger::log('query.mongo' , 'Successfull query');
			Logger::log('query.mongo' , $result);
			return $result;
		}

		public function num_rows()
		{
			try 
			{
				return $this->result->count();
			}
			catch (Exception $e)
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, $this->query , $e->getMessage());
			}
		}

		public function get_row()
		{
			try 
			{
				if($this->result->count() > 0)
				{
					$this->result->next();
    				return $this->result->current();
				}
				else 
				{
					throw new DBException(DBException::$EX_CODE_NOT_FOUND, array());
				}
			}
			catch(DBException $e)
			{
				throw $e;
			}
			catch (Exception $e)
			{
				throw new DBException(DBException::$EX_CODE_DB_ERROR, $this->query , $e->getMessage());
			}
		}

		public function get_index_row()
		{
			$row = $this->get_row();
			return (array) $row;
		}

		public function get_rows()
		{
			$rows = array();
			foreach ($this->result as $id => $row) 
			{
				$rows[] = $row;
			}
			return $rows;
		}

		public function get_index_rows()
		{
			$rows = array();
			foreach ($this->result as $id => $row) 
			{
				$rows[] = (array) $row;
			}
			return $rows;
		}

		public function insert($table_name , $record)
		{
			try 
			{
				Logger::log('query.mongo' , '-----------------------');
				Logger::log('query.mongo' , 'Insert');
				Logger::log('query.mongo' , 'Database name : '.$this->database_name);
				Logger::log('query.mongo' , $this->connection);
				Logger::log('query.mongo' , 'Table name : '.$table_name);
				Logger::log('query.mongo' , $record);

				$this->upsert_result = $this->connection->$table_name->insert($record , array('w' => 1));
				Logger::log('query.mongo' , '-----------------------');
			}
			catch (Exception $e)
			{
				throw $e;
			}
		}

		public function insert_batch($table_name , $records)
		{
			try 
			{
				Logger::log('query.mongo' , '-----------------------');
				Logger::log('query.mongo' , 'Batch Insert');
				Logger::log('query.mongo' , 'Database name : '.$this->database_name);
				Logger::log('query.mongo' , $this->connection);
				Logger::log('query.mongo' , 'Table name : '.$table_name);
				Logger::log('query.mongo' , $records);

				$this->upsert_result = $this->connection->$table_name->batchInsert($records , array('w' => 1));
				Logger::log('query.mongo' , '-----------------------');
			}
			catch (Exception $e)
			{
				throw $e;
			}
		}

		public function insert_id()
		{
			if(!empty($this->upsert_result))
			{
				return $this->upsert_result['upserted'];
			}
			else 
			{
				throw new DBException(DBException::$EX_CODE_DB_INSERT_ID);
			}
		}

		public function update($table_name , $record , $conditions = array() , $order = array() , $limit = array())
		{
			try 
			{
				Logger::log('query.mongo' , '-----------------------');
				Logger::log('query.mongo' , 'Update Query');
				Logger::log('query.mongo' , 'Database name : '.$this->database_name);
				Logger::log('query.mongo' , 'Table name : '.$table_name);

				$mongo_conditions = $this->prepare_where($conditions);
				
				Logger::log('query.mongo' , 'Prepared Condition');
				Logger::log('query.mongo' , $mongo_conditions);
				Logger::log('query.mongo' , json_encode($mongo_conditions));
				Logger::log('query.mongo' , 'Record');
				Logger::log('query.mongo' , $record);
				Logger::log('query.mongo' , json_encode($record));

				$result = $this->connection->$table_name->update($mongo_conditions, array('$set' => $record) , array('multiple' => true));
				
				Logger::log('query.mongo' , 'Result');
				Logger::log('query.mongo' , $result);

				$error = $this->connection->lastError();
				Logger::log('query.mongo' , 'Errors');
				Logger::log('query.mongo' , $error);
				if($error['n'] == 0)
				{
					Logger::log('query.mongo' , 'No records to update');
					// throw new DBException(DBException::$EX_CODE_NO_UPDATE, $conditions);
				}

				return $result;
			}
			catch (DBException $e)
			{
				throw $e;
			}
			catch (Exception $e)
			{
				throw $e;
			}
		}

		public function delete($table_name , $conditions = array() , $order = array() , $limit = array())
		{
			try 
			{
				$mongo_conditions = $this->prepare_where($conditions);
				$result = $this->connection->$table_name->remove($mongo_conditions);

				$error = $this->connection->lastError();
				if($error['n'] == 0)
				{
					// throw new DBException(DBException::$EX_CODE_NO_UPDATE, $mongo_conditions);
				}
				return $result;
			}
			catch (DBException $e)
			{
				throw $e;
			}
			catch (Exception $e)
			{
				throw $e;
			}
		}

		/*
		private function prepare_where($conditions)
		{
			$mongo_conditions = array();

			foreach ($conditions as $key => $conds) 
			{
				if($key == 'OR')
				{
					$ors = array();
					foreach ($conds as $col => $cons) 
					{
						$ands = array();
						foreach ($cons as $column => $value) 
						{
							$and = $this->prepare_condition($column , $value);
							$ands[$and['column']] = $and['value'];		
						}
						$ors[] = $ands;
					}
					$mongo_conditions['$or'] = $ors;
				}
				else 
				{
					$and = $this->prepare_condition($key , $conds);
					$mongo_conditions[$and['column']] = $and['value'];
				}
			}
			return $mongo_conditions;
		}
		/**/

		private function prepare_where($conditions)
		{
			$mongo_conditions = array();

			/*
			if(isset($conditions['OR']))
			{
				$columns = $conditions['OR'];
				$mongo_conditions = $this->prepare_where_or($columns);
			}
			else if(isset($conditions['AND']))
			{
				$columns = $conditions['AND'];
				$mongo_conditions = $this->prepare_where_and($columns);
			}
			else 
			{
				$columns = $conditions;
				$mongo_conditions = $this->prepare_where_and($columns);
			}
			/**/

			$columns = $conditions;
			$mongo_conditions = $this->prepare_where_and($columns);

			return $mongo_conditions;
		}	

		private function prepare_where_and_list($list)
		{
			$ands = array();
			for($i = 0 ; $i < count($list) ; $i ++)
			{
				$ands[] = $this->prepare_where_and($list[$i]);		
			}
			$ands = array_filter($ands);

			$and_condition = array();
			if(count($ands) > 0)
			{
				$and_condition = ['$and' => $ands];
			}

			return $and_condition;
		}

		private function prepare_where_and($columns)
		{
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
					$and = $this->prepare_condition($column , $value);
					$ands[] = [$and['column'] => $and['value']];
				}
			}
			$ands = array_filter($ands);

			$and_condition = array();
			if(count($ands) > 0)
			{
				$and_condition = ['$and' => $ands];
			}

			return $and_condition;
		}

		private function prepare_where_or_list($list)
		{
			$ors = array();
			for($i = 0 ; $i < count($list) ; $i ++)
			{
				$ors[] = $this->prepare_where_or($list[$i]);		
			}
			$ors = array_filter($ors);

			$or_condition = array();
			if(count($ors) > 0)
			{
				$or_condition = ['$or' => $ors];
			}

			return $or_condition;
		}

		private function prepare_where_or($columns)
		{
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
					$or = $this->prepare_condition($column , $value);
					$ors[] = [$or['column'] => $or['value']];
				}
			}
			$ors = array_filter($ors);

			$or_condition = array();
			if(count($ors) > 0)
			{
				$or_condition = ['$or' => $ors];
			}

			return $or_condition;
		}

		private function prepare_condition($column , $value)
		{
			if(isset($value['operator']))
			{
				$operator = $value['operator'];
				$val = $value['value'];
				$case_sensitive = isset($value['case_sensitive']) ? $value['case_sensitive'] : true;

				$operator_map = array('IS' => '', 'GT' => '$gt' , 'GTE' => '$gte' , 'IN' => '$in' , 'LT' => '$lt' , 'LTE' => '$lte' , 'NE' => '$ne' , 'NIN' => '$nin' , 'NOT' => '$ne' , 'LIKE' => '$regex' , 'LENGTH' => '$size' , 'BETWEEN' => '');
				if(!isset($operator_map[$operator]))
				{
					throw new DBException(DBException::$EX_CODE_INVALID_OPERATOR , $value);
				}

				$mongo_val = $val;
				if(!$case_sensitive)
				{
					$mongo_val = new MongoRegex("/^$val\$/i");
				}
				
				$mongo_operator = $operator_map[$operator];
				if($operator == 'BETWEEN')
				{
					return array('column' => $column , 'value' => array('$gte' => $val[0] , '$lte' => $val[1]));	
				}
				if($operator == 'LIKE')
				{
					if($case_sensitive)
					{
						return array('column' => $column , 'value' => new MongoRegex("/$val/"));	
					}
					else 
					{
						return array('column' => $column , 'value' => new MongoRegex("/$val/i"));	
					}
				}
				if($mongo_operator != "")
				{
					return array('column' => $column , 'value' => array($mongo_operator => $mongo_val));
				}
				else 
				{
					return array('column' => $column, 'value' => $mongo_val);		
				}
			}
			else if(is_array($value))
			{
				return array('column' => $column , 'value' => array('$in' => $value));
			}
			else 
			{
				return array('column' => $column, 'value' => $value);
			}
		}

		private function prepare_order($order)
		{
			$_order = array();
			if($order == "rand")
			{
				$_order = array();
			}
			else if($order != NULL && count($order) > 0)
			{
				foreach($order as $column => $ord)
				{
					$ord = strtoupper($ord) == 'ASC' ? 1 : -1;
					$_order[$column] = $ord;
				}
			}
			return $_order;
		}
	}