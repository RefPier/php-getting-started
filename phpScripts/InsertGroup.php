<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
	 $group_name = isset($_POST['group_name']) ? $_POST['group_name'] : '';
	 
	 $db = new DbOperation(); 
	 $result = $db->insertGroup($facebook_id,$group_name);
 
 	if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Group registered successfully';
 	}elseif($result == 2){
		 $response['error'] = true; 
		 $response['message'] = 'User not found';
	 }else{
		 $response['error'] = true;
		 $response['message']='Group not registered';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
