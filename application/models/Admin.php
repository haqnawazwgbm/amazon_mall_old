<?php
/**
*
*/
class Admin extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	function InsertData($table,$Data)
	{
		$Insert = $this->db->insert($table,$Data);
		if ($Insert):
			return true;
		endif;
	}
	    /*
     * get rows from the users table
     */
    function getRows($params = array(), $table){
        if(array_key_exists("selection",$params)){
             $this->db->select($params['selection']);
        } else {
             $this->db->select('*');
        }
        $this->db->from($table);
        //Joins the tables 
         if (array_key_exists('innerJoin',$params)) {
                foreach ($params['innerJoin'] as $value) {
                   $this->db->join($value['table'], $value['condition'], $value['joinType']);
                }
                
                
        }
        //Group by fetching
        if (array_key_exists('groupBy',$params)) {
                foreach ($params['groupBy'] as $value) {
                   $this->db->group_by($value);
                }
                              
        }
        //Distinct fetch
        if(array_key_exists("distinct",$params)){
             $this->db->distinct($params['distinct']);
        } 
        // Order by
        if (array_key_exists('orderBy', $params)) {
            $this->db->order_by($params['orderBy']);
        }
        
        if(array_key_exists("like_conditions",$params)){
            foreach ($params['like_conditions'] as $key => $value) {
                $this->db->like($key, $value);
            }
        }
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
           
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }
        }
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            $query = $this->db->get();
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $query->num_rows();
            }elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
                $result = ($query->num_rows() > 0)?$query->row_array():FALSE;
            }elseif(array_key_exists("returnType", $params) && $params['returnType'] == 'object') {
                $result = ($query->num_rows() > 0) ? $query->result(): FALSE;
            }else{
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        //return fetched data
        return $result;
    }
    
	function getAllData($table,$specific='',$Where='',$order='',$limit='',$groupBy='')
	{
		// If Condition
		if (!empty($Where)):
			$this->db->where($Where);
		endif;
		// If Specific Columns are require
		if (!empty($specific)):
			$this->db->select($specific);
		else:
			$this->db->select('*');
		endif;

		if (!empty($groupBy)):
			$this->db->group_by($groupBy);
		endif;
		// if Order
		if (!empty($order)):
			$this->db->order_by($order);
		endif;
		// if limit
		if (!empty($limit)):
			$this->db->limit($limit);
		endif;
		// get Data
		$GetData = $this->db->get($table);
		return $GetData->result();
	}
	function UpdateDB($table,$Where,$Data)
	{
		$this->db->where($Where);
		$Update = $this->db->update($table,$Data);
		if ($Update):
			return true;
		else:
			return false;
		endif;
	}
	function Authentication($table,$data)
	{
		$this->db->where($data);
		$query = $this->db->get($table);
		if ($query) {
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	
	function DJoin($field,$tbl,$jointbl1,$jointbl3 = '',$Joinone,$Where = '',$order = '',$groupy = '')
    {
        $this->db->select($field);
        $this->db->from($tbl);
        $this->db->join($jointbl1,$Joinone);
        if (!empty($jointbl3)):
            foreach ($jointbl3 as $Table => $On):
                $this->db->join($Table,$On);
            endforeach;
        endif;
        // if Group
		if (!empty($groupy)):
			$this->db->group_by($groupy);
		endif;
        if(!empty($order)):
            $this->db->order_by($order);
        endif;
        if(!empty($Where)):
            $this->db->where($Where);
        endif;
        $query=$this->db->get();
        return $query->result();
    }

    function DeleteDB($table,$where)
    {
    	$this->db->where($where);
    	$done = $this->db->delete($table);
    	if ($done) {
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }

	function Encode_html($str) {
    return trim(stripslashes(htmlentities($str)));
	}

	function Encode($str) {
	    return trim(  htmlentities( $str, ENT_QUOTES ) ) ;
	}

	function Decode($str) {
	    return html_entity_decode(stripslashes($str));
	}

	function Encrypt($password) {
	    return crypt(md5($password), md5($password));
	}

	function fileUpload($param,$temp,$location)
	{
		// Allowing Files with extensions lists
	  	$allow_ext = array("png","jpg","jpeg","gif",'pdf','xlsx','csv','docx');
	  	// Checking Diretory if Exists then upload if not then create one
        $uploadPath = 'assets/uploads/'.$location;
		// Now Uploading Files to Directory
        $FileReturn = '';
		if(!empty($param))
        {
            if($param !=''){
            	$explode = explode(".", $param);
				$Ext = end($explode);
                $ext = strtolower($Ext);
                $fileName = date("Ymdhis").$param;
                if(in_array($ext, $allow_ext)){
                    move_uploaded_file($temp,$uploadPath.'/'.$fileName);
                    $FileReturn = array('orignal'=>$param,'filename'=>$fileName,'ext'=>$ext);
                    return $FileReturn;
                }
                else{
                    $data['error_msg'] = "Please upload valid File";
                }
            }
        }
	}

	function pr($val)
	{
		echo "<pre>";
		print_r($val);
		die;
	}
}
?>
