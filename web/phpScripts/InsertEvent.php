<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 $date = isset($_POST['date']) ? $_POST['date'] : '';
	 $hour = isset($_POST['hour']) ? $_POST['hour'] : '';
	 $description = isset($_POST['description']) ? $_POST['description'] : '';
	 
	 $db = new DbOperation(); 
	 $result = $db->insertEvent($group_id, $date, $hour, $description);
 
 	if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Event registered successfully';
 	}else{
		 $response['error'] = true;
		 $response['message']='Event not insert';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
