<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
	 $description = isset($_POST['description']) ? $_POST['description'] : '';
	 
	 $db = new DbOperation(); 
	 $result = $db->insertCleaningRound($group_id, $facebook_id, $description);
 
 	if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Cleaning Schedule registered successfully';
 	}else{
		 $response['error'] = true;
		 $response['message']= 'Cleaning Schedule not insert';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
