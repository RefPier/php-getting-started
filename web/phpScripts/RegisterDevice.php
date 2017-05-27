<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
	 $firebase_token = isset($_POST['firebase_token']) ? $_POST['firebase_token'] : '';
	 $name = isset($_POST['name']) ? $_POST['name'] : '';
	 $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
	 $group_id = null;
	 $debit_credit = 0;
	 
	 
	 $db = new DbOperation(); 
	 
	 $result = $db->registerDevice($facebook_id,$firebase_token,$name,$surname,$group_id,$debit_credit);
	 
	 
	 if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Device registered successfully';
	 }elseif($result == 2){
		 $response['error'] = true; 
		 $response['message'] = 'Device already logged';
	 }elseif ($result == 1){
		 $response['error'] = true;
		 $response['message']='Device not registered';
	 }else{
		 $result2 = $db->getDebitAndGroupId($facebook_id);
		 $row = $result2->fetch_array();
		 
		 $search_group_name = $db->getGroupName( $row['group_id']);
		 $group_name = $search_group_name->fetch_array();
		 
		 $response['error'] = false; 
		 $response['message'] = 'User logged again';
		 $response['group_id'] = $row['group_id'];
		 $response['debit_credit'] = $row['debit_credit'];
		 $response['group_name'] = $group_name['group_name'];
		 
		 
		 }
	 
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
