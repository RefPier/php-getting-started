<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
	 
	 $db = new DbOperation(); 
	 $result = $db->setCleanRound($facebook_id);
 
 	if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Done';
 	}else{
		 $response['error'] = true;
		 $response['message']= 'Error';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
