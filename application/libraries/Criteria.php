<?php

    class Criteria 
    {
        private $sEcho;
        private $start_index = -1;
        private $count = 0;
        private $sort_criteria = array();
        private $criterias = array();
        private $require_facet = true;
        private $require_result = true;
        private $require_count = true;
        
        public function __construct($params = array())
        {
        	if(!empty($params))
        	{
	            $this->sEcho = $params['sEcho'];
	            $this->set_start_index($params['iDisplayStart']);
	            $this->set_count($params['iDisplayLength']);
	            
	            if($params['sColumns'])
	            {
	            	$columns = explode(',' , $params['sColumns']);
	            	$this->setup_sort($columns, $params);
	            }
        	}
        }
        
        public function add_criteria($column , $value)
        {
            $this->criterias[] = array(
                'column' => $column,
                'value' => $value
            );
        }
        
        public function get_criterias()
        {
        	$criteriaMap = array();
        	foreach($this->criterias as $criteria)
        	{
        		$criteriaMap[$criteria['column']] = $criteria['value'];
        	}
        	return $criteriaMap;
        }
        
        public function clear_criterias()
        {
            $this->criterias = array();
        }
        
        public function setup_sort($columns , $params)
        {
        	$sortColumn = $params['iSortCol_0'];
        	if($sortColumn != "")
        	{
        		$sortDirection = $params['sSortDir_0'];
        		if($sortDirection == 'asc')
        		{
        			$this->set_sort($columns[$sortColumn], true);
        		}
        		else
        		{
        			$this->set_sort($columns[$sortColumn], false);
        		}
        	}
        }
        
        public function set_sort($criteria , $ascending , $object = "")
        {
            $this->sort_criteria = array(
                'column' => $criteria,
                'ascending' => $ascending,
                'object' => $object
            );
        }
        
        public function get_sort()
        {
        	return $this->sort_criteria;
        }

        public function get_sorts()
        {
            $criteriaMap = array();
            foreach($this->sort_criteria as $criteria)
            {
                $criteriaMap[$criteria['column']] = $criteria;
            }
            return $criteriaMap;
        }
        
        public function set_start_index($start_index)
        {
            $this->start_index = $start_index;
        }

        public function get_start_index()
        {
            return $this->start_index;
        }
        
        public function set_count($count)
        {
            $this->count = $count;
        }
        
        public function get_count()
        {
            return $this->count;
        }
        
        public function set_require_facet($require)
        {
        	$this->require_facet = $require;
        }
        
        public function get_require_facet()
        {
        	return $this->require_facet;
        }

        public function set_require_count($require)
        {
        	$this->require_count = $require;
        }
        
        public function get_require_count()
        {
        	return $this->require_count;
        }
        
        public function set_require_result($require)
        {
        	$this->require_result = $require;
        }
        
        public function get_require_result()
        {
        	return $this->require_result;
        }
        
        public function prepare_params($params , $searchClass , $sortClass)
        {
            $i = 1;
            foreach($this->criterias as $criteria)
            {
            	$column = $criteria['column'];
                $params['column' . $i] = $searchClass->${$column};
                $params['value' . $i] = $criteria['value'];
                $i ++;
            }
            
            $column = $this->sort_criteria['column'];
            if($column != "")
            {
	            $params['sortColumn'] = $sortClass->${$column};
	            $params['ascending'] = $this->sort_criteria['ascending'] ? "true" : "false";
            }
            else
            {
            	$params['sortColumn'] = "";
	            $params['ascending'] = "false";
            }
            
            $params['start_index'] = $this->start_index;
            $params['rowCount'] = $this->count;
            $params['require_facet'] = $this->require_facet;
            
            return $params;
        }
        
        public function prepare_response($response)
        {
            $gridResponse = array();
            $gridResponse['sEcho'] = $this->sEcho;
            $gridResponse['iTotalRecords'] = count($response['result']);
            $gridResponse['iTotalDisplayRecords'] = $response['totalCount'];
            $gridResponse['aaData'] = $response['result'];
            $gridResponse['objects'] = $response['objects'];
            return $gridResponse;
        }
    }