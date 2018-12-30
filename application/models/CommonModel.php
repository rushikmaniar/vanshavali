<?php 

class CommonModel extends CI_Model
{
	public $imageExtensions = array('jpg','png','bmp','jpeg','gif','ico');
	public $phpDateFormat = 'm/d/Y g:i:a';  /// default Date Format for php
	public $jsDateFormat = 'mm/dd/yy';  /// default Date Format for Js
	public $STIME = '12:00:00 AM';  /// default Start Time
	public $ETIME = '11:59:59 PM';  /// default End  Time
	
	///////////////////////////////////
	#######  COMMON FUNCTIONS  ########
	///////////////////////////////////
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
	}

    
    /**
     *Get All Record based on table and condition
     * @param string $table
     * @param array/string $where
     * @param string/array $select  list of column for select , NOTE: add column alias during join used (array('*','table.col1 as column1','table.col2 as column2'))
     * @param array $joins default empty array , default join type LEFT  array('table' => tablename,'condition'=>condition,'jointype'=> 'LEFT,RIGHT,OTHER..');
     * @param array $likearray default empty array like array are join with OR (title LIKE %title% OR title1 LIKE %title1%)
     * @param int $limit  default false
     * @param int $offset default false
     * @param string/array $orderby default id order by column
     * @param string  $order default DESC ,  order = ASC or DESC
     * @param string/array $groupby
     */
    public function getRecord($table, $where=NULL, $select='*', $limit=FALSE,$offset=0)
    {
    	$this->db->from($table);
    	$this->db->select($select);
    	// where condition
    	if($where){
    		$this->db->where($where);
    	}
    	 
    	if($limit){
    		$this->db->limit($limit,$offset);
    	}
    	 
    	return $this->db->get();
    	 
    }
    
    public function dbjoin($joins)
    {
        if(is_array($joins) && !empty($joins)){
            foreach($joins as $joinInfo){
                $joinType = (array_key_exists('jointype', $joinInfo)) ? $joinInfo['jointype'] : 'LEFT';
                $this->db->join($joinInfo['table'], $joinInfo['condition'], $joinType);
            }
        }
        return $this;
    }
    
    public function dblike($likearray)
    {
        if(count($likearray) > 0){
            $this->db->group_start();
            $this->db->or_like($likearray);
            $this->db->group_end();
        }
        return $this;
    }
    
    public function dbwhere($type,$whr)
    {
    	if($type && !empty($whr))
    	{
	    	$this->db->group_start();
	    	if($type === 'OR'){
		    	$this->db->or_where($whr);
	    	}
	    	if($type === 'IN' && isset($whr[0]) && isset($whr[1]) && !empty($whr[1])){
		    	$this->db->where_in($whr[0],$whr[1]);    		
	    	}
	    	if($type === 'NOTIN' && isset($whr[0]) && isset($whr[1]) && !empty($whr[1])){
	    		$this->db->where_not_in($whr[0],$whr[1]);
	    	}
	    	$this->db->group_end();
    	}    	
    	return $this;
    		
    	/* 
    	$this->db->where_not_in()
    	$this->db->or_where_not_in() 
    	*/
    	
    }
    public function dbOrderBy($orderBy)
    {
    	if(is_array($orderBy)){
    		foreach ($orderBy as $orderkey => $orderval){
    			$this->db->order_by($orderkey,$orderval);
    		}
    	}
    	return $this;
    }
    public function dbGroupBy($groupBy)
    {
    	if($groupBy){
    		$this->db->group_by($groupBy);
    	}
    	return $this;
    }
    
    
    
    public function getSum($table,$column,$whr=null)
    {
    	$this->db->select_sum($column);    	
    	$this->db->from($table);
    	if($whr){
    		$this->db->where($whr);
    	}
    	
    	return $this->db->get()->row()->$column;
    }
    
    

    function save($table,$array){
       if(!array_key_exists('created_at', $array)){
    		$array['created_at'] = now();
    	}
    	if(!array_key_exists('updated_at', $array)){
    		$array['updated_at'] = now();
    	}
    		
        $this->db->insert($table,$array);

        return $this->db->insert_id();
    }

    public function update($table,$array,$where)
    {
        if(!array_key_exists('updated_at', $array)){
    		$array['updated_at'] = now();
    	}
        $this->db->where($where);
       return $this->db->update($table,$array);
    }
    
    public function updateIncrement($table,$array,$where)
    {
    	$updateArray = array();
    	foreach ($array as $col)
    		$updateArray[] = $col;
    
    	$updateArray[] = array( 'col' => 'updated_at', 'val' => now(), 'action' => TRUE);
    
    	foreach ($updateArray as $updateCol)
    	{
    		$this->db->set($updateCol['col'], $updateCol['val'], ($updateCol['action']) ? TRUE:FALSE);
    	}
    
    	$this->db->where($where);
    	return $this->db->update($table);
    }

    public function delete($table,$where)
    {
        $this->db->where($where);
        return $this->db->delete($table);
    }

    public function slug($string)
    {
       return strtolower(preg_replace('/[^A-Za-z0-9\-]/','', $string));
    }

    public function GetList($table,$value,$joins,$likearray,$where,$limit,$offset,$order_by,$order)
    {
        $this->db->start_cache();
        $this->db->select($value);

        if (is_array($joins) && count($joins) > 0)
        {
            foreach($joins as $k => $v)
            {
                $this->db->join($v['table'], $v['condition'], $v['jointype']);
            }
        }
        if(!empty($where))
        {
            $this->db->where($where);
        }
        if(!empty($likearray))
        {
        $this->db->where($likearray);
        }
        $this->db->order_by($order_by,$order);
        $this->db->stop_cache();
        $query['total_records']=$this->db->get($table)->num_rows();
        $query['results']=$this->db->get($table, $limit, $offset)->result();

        return $query;

    }
    
    /**
     * count number of record in table 
     * @param string $table
     * @param string/array $whr
     */
    public function countRecord($table,$where=NULL,$select='*',$joins=NULL,$likearray=NULL,$groupby=FALSE)
    {
    	$this->db->from($table);
    	$this->db->select($select);
    	
    	// where condition
    	if($where){
    		$this->db->where($where);
    	}
    	
    	if(is_array($joins) && !empty($joins)){
    		foreach($joins as $joinInfo){
    			$joinType = (array_key_exists('jointype', $joinInfo)) ? $joinInfo['jointype'] : 'LEFT';
    			$this->db->join($joinInfo['table'], $joinInfo['condition'], $joinType);
    		}
    	}
    	
    	if(count($likearray) > 0){
    		$this->db->group_start();
    		$this->db->or_like($likearray);
    		$this->db->group_end();
    	}
        if($groupby){
            $this->db->group_by($groupby);
        }
    	
    	 
    	return $this->db->count_all_results();

    }
    
    
    /**
     * this function will change status of is_active Column (if status 1 then set 0 and if status 0 then set 1 autometically from query)
     * @param string $table table name  
     * @param int $id   unique id for whr condition 
     */
    /** all record function use to find  all record by table only  order wise **/
    public function changeStatus($table,$id)
    {
    	$query = "UPDATE ".$table." SET is_active = if(is_active='0','1','0' ) Where id=".$id;
    	return $this->db->query($query);
    }
    
    
    
    /**
     * Create Pagination and Pagination Link of table record 
     * get result based on pagination and condition 
     * 
     * @param string $baseUrl
     * @param string $table
     * @param array/string $where
     * @param string/array $select  list of column for select , NOTE: add column alias during join used (array('*','table.col1 as column1','table.col2 as column2'))
     * @param array $joins default empty array , default join type LEFT  array('table' => tablename,'condition'=>condition,'jointype'=> 'LEFT,RIGHT,OTHER..');
     * @param array $likearray default empty array like array are join with OR (title LIKE %title% OR title1 LIKE %title1%)
     * @param int $limit  default false
     * @param int $offset default false
     * @param string/array $orderby default id order by column
     * @param string  $order default DESC ,  order = ASC or DESC
     * @param string/array $groupby
     * @return array result = record result , pageLink = page link (html of number of page link)
     */
    public function createPagination($baseUrl,$table, $where=NULL, $select='*', $joins=array(), $likearray=array(), $limit=FALSE,$offset=0,$orderby='id',$order='DESC',$groupby=FALSE)
    {
    	$this->load->library('pagination');
    	$configParam = array();
    	$configParam['base_url'] = $baseUrl;
    	$configParam['total_rows'] = self::countRecord($table,$where,$select,$joins,$likearray,$groupby);
    	$configParam['per_page'] = $limit;
    	$configParam['reuse_query_string'] = TRUE;
    	$configParam['num_links'] = 3;
    	 
    	$configParam['full_tag_open'] = '<ul class="pagination">';
    	$configParam['full_tag_close'] = '</ul>';
    	$configParam['first_link'] = 'First';
    	$configParam['last_link'] = 'Last';
    	$configParam['first_tag_open'] = '<li class="page-link">';
    	$configParam['first_tag_close'] = '</li>';
    	$configParam['prev_link'] = '&laquo';
    	$configParam['prev_tag_open'] = '<li class="page-link">';
    	$configParam['prev_tag_close'] = '</li>';
    	$configParam['next_link'] = '&raquo';
    	$configParam['next_tag_open'] = '<li class="page-link">';
    	$configParam['next_tag_close'] = '</li>';
    	$configParam['last_tag_open'] = '<li class="page-link">';
    	$configParam['last_tag_close'] = '</li>';
    	$configParam['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0)">';
    	$configParam['cur_tag_close'] = '</a></li>';
    	$configParam['num_tag_open'] = '<li class="page-link">';
    	$configParam['num_tag_close'] = '</li>';
    	 
    	$this->pagination->initialize($configParam);
    	$output = array(
    	    'page_link' => $this->pagination->create_links(),
    	    'totalRecord' => $configParam['total_rows'],
    	);
    	return $output;
    }
    
    
	public function doUpload($fileUpload,$path,$fileName=FALSE,$type = false)
    {
    	if(!$type){
    		$type = implode('|', $this->imageExtensions);
    	}
    	$configParam = array();
    	$configParam['overwrite']= true;
    	$configParam['upload_path']          = $path;
    	$configParam['allowed_types']        = $type;
    	if ($fileName){
    		$configParam['file_name'] = str_replace('.', '_', $fileName); 
    	}   		
    	    
    	$this->load->library('upload', $configParam);
    	$this->upload->initialize($configParam);
    
    	if($this->upload->do_upload($fileUpload)){    		
    		return $this->upload->data();
    	}
    	else {
    		echo $this->upload->display_errors();
    		return false;
    	}
    }


    /**
     * Send mail
     * 
     * @param string $to
     * @param string $subject
     * @param string $text
     * @param string $template
     * @param array $data
     * @return boolean
     */
    public function send_mail($to, $subject,$text,$template=false,$data=false)
    {
        if($template && !empty($data))
        {
            $text = $this->load->view($template,array('data' => $data),TRUE);
        }
        
        $config = Array(
            'protocol' => $this->config->config['smtp_protocol'],
            'smtp_host' => $this->config->config['smtp_host'],
            'smtp_port' => $this->config->config['smtp_port'],
            'smtp_user' => $this->config->config['smtp_user'],
            'smtp_pass' => $this->config->config['smtp_password'],
            'mailtype'  => 'html',
            'charset'   => $this->config->config['charset']
            );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        
        $this->email->from($this->config->config['smtp_set_from'], $this->config->config['smtp_from_name']);
        $this->email->reply_to($this->config->config['smtp_replay_to'], $this->config->config['replay_to_name']);
        
        $this->email->to($to);        
        $this->email->subject($subject);
        $this->email->message($text);        
        $result = $this->email->send();
        return $result;
    }
    
    
    /**
     * Convert Currency To CAD(C)
     * $from_Currency (Currency like INR,USD)
     * $to_currency  (Default Currency CAD)
     * $amount  (Number of Amount)
     */
    public function currencyConverter($from_Currency,$amount)
    {
        if($from_Currency && $amount)
        {
            $from_Currency = urlencode($from_Currency);
            $to_Currency = urlencode('CAD');
            $get = file_get_contents("https://finance.google.com/finance/converter?a=1&from=$from_Currency&to=$to_Currency");
            $get = explode("<span class=bld>",$get);
            $get = explode("</span>",$get[1]);
            $converted_currency = preg_replace("/[^0-9\.]/", null, $get[0]);
            return $converted_currency * $amount;
        }else
        {
           return false;
        }
    }
    
    public function createAlias($tableName,$separator='_')
    {
    	$tableAlias = array();
    	if(is_array($tableName))
    	{
    		foreach ($tableName as $tableData)
    		{
    			$table_name = isset($tableData[0]) ? $tableData[0] : false;
	    		$tblAlias = isset($tableData[1]) ? $tableData[1] : $table_name;
	    		$aliasIgnore = isset($tableData[2]) ? $tableData[2] : array();
	    		$table_alias = isset($tableData[3]) ? $tableData[3] : $table_name;
	    		
	    		if($table_name && $tblAlias)
	    		{
		    		$tablequery = $this->db->query('SELECT `COLUMN_NAME` FROM information_schema.columns WHERE TABLE_SCHEMA = "'.$this->db->database.'" AND TABLE_NAME = "'.$table_name.'"')->result();
		    		foreach ($tablequery as $row)
		    		{
		    			if(!in_array($row->COLUMN_NAME, $aliasIgnore)){
		    				$tableAlias[] = $table_alias.'.'.$row->COLUMN_NAME .' AS '.$tblAlias.$separator.$row->COLUMN_NAME;
		    			}
		    		}
	    		}
    		}
    	}
    	return $tableAlias;
    }
    
    public function dateToTimestamp($date)
    {
    	return strtotime($date);
    }
    
    public function removeTimeFromDate($date,$no,$type)
    {
//     	$date = (is_numeric($date)) ? $date : $this->dateToTimestamp($date);
    	if($no > 0)
    	{
    		$type = ($no > 1) ? $type.'s' : $type;
	    	$date = strtotime('-'.$no.' '.$type, $date);
    	}
    	return $date;
    }
    
    /**
     * ref of timespan function of codeigniter 
     * @param unknown_type $startDate
     * @param unknown_type $endDate
     * @return multitype:number
     */
    public function getDateDiff($startDate , $endDate)
    {
    	$dayInfo = array();
    	
    	if($startDate && $endDate && is_numeric($startDate) && is_numeric($endDate)){    	
    		$startDate = ($endDate <= $startDate) ? 1 : $endDate - $startDate;
	    	////count year
	    	$years = floor($startDate / 31557600);
	    	$dayInfo['year'] = $years;
	    	
	    	//// count month
	    	$months = floor($startDate / 2629743);    
	    	$dayInfo['month'] = $months;
	    
	    	/// count week
	    	$weeks = floor($startDate / 604800);
	    	$dayInfo['week'] = $weeks;
	    
	    	/// count day 
	    	$days = floor($startDate / 86400);
	    	$dayInfo['day'] = $days;
	    
	    	/// count hour 
	    	$hours = floor($startDate / 3600);    
	    	$dayInfo['hour'] = $hours;
	    
	    	/// count minute
	    	$minutes = floor($startDate / 60);    
	    	$dayInfo['minute'] = $minutes;
    	}

    	return $dayInfo;
    }
    
    public function getDateDiffByTime($startDate , $endDate,$skip=array())
    {
    	$dayInfo = array();
    	 
    	if($startDate && $endDate && is_numeric($startDate) && is_numeric($endDate)){
    		$startDate = ($endDate <= $startDate) ? 1 : $endDate - $startDate;
    		
    		////count year
    		if(!in_array('year', $skip)){
	    		$years = floor($startDate / 31557600);
	    		$dayInfo['year'] = (int)$years;
	    		$startDate = ($years > 0) ? ($startDate-($years * 31557600)):$startDate;
    		}
    		    
    		//// count month
    		if(!in_array('month', $skip)){
	    		$months = floor($startDate / 2629743);
	    		$dayInfo['month'] = (int)$months;
	    		$startDate = ($months > 0) ? ($startDate-($months * 2629743)):$startDate;
    		}
    	  
    		/// count week
    		if(!in_array('week', $skip)){
	    		$weeks = floor($startDate / 604800);
	    		$dayInfo['week'] = (int)$weeks;
	    		$startDate = ($weeks > 0) ? ($startDate-($weeks * 604800)):$startDate;
    		}
    	  
    		/// count day
    		if(!in_array('day', $skip)){
	    		$days = floor($startDate / 86400);
	    		$dayInfo['day'] = (int)$days;
	    		$startDate = ($days > 0) ? ($startDate-($days * 86400)):$startDate;
    		}
    	  
    		/// count hour
    		if(!in_array('hour', $skip)){
	    		$hours = floor($startDate / 3600);
	    		$dayInfo['hour'] = (int)$hours;
	    		$startDate = ($hours > 0) ? ($startDate-($hours * 3600)):$startDate;
    		}
    	  
    		/// count minute
    		if(!in_array('minute', $skip)){
	    		$minutes = floor($startDate / 60);
	    		$dayInfo['minute'] = (int)$minutes;
	    		$startDate = ($minutes > 0) ? ($startDate-($minutes * 60)):$startDate;
    		}
    	}    
    	return $dayInfo;
    }
}
