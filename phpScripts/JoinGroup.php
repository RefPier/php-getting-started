<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 
	 $db = new DbOperation(); 
	 $result = $db->insertInExistingGroup($facebook_id,$group_id);
 
 	if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Group joined successfully';
 	}elseif($result == 2){
		 $response['error'] = true; 
		 $response['message'] = 'User not found';
	 }else{
		 $response['error'] = true;
		 $response['message']='Error';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
