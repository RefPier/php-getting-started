<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
	 $firebase_token = isset($_POST['firebase_token']) ? $_POST['firebase_token'] : '';
	 
	 $db = new DbOperation(); 
	 $result = $db->storeToken($facebook_id, $firebase_token);
 
 	if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'stored';
 	}else{
		 $response['error'] = true;
		 $response['message']= 'error';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
