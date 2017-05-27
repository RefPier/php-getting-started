<?php

require_once 'DbOperation.php';
 
 $db = new DbOperation(); 
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 $contact_name = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
	 $contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
	 
	 $db = new DbOperation(); 
	 
	 $result = $db->removeContactsNumber($group_id, $contact_name, $contact_number);
	 
	 if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Contact removed successfully';
	}else{
		 $response['error'] = true;
		 $response['message']='Error';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
