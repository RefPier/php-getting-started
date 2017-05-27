<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 
	 $firebase_token = isset($_POST['firebase_token']) ? $_POST['firebase_token'] : '';
	 $db = new DbOperation();
	 
	 $result = $db->controlLogin($firebase_token);
	 $row = $result->fetch_array();
	 if($result->num_rows > 0){
		 
		 $search_group_name = $db->getGroupName( $row['group_id']);
		 $group_name = $search_group_name->fetch_array();
		 
		 $response['error'] = false; 
		 $response['message']='Just Logged';
		 $response['facebook_id']=$row['facebook_id'];
		 $response['name']=$row['name'];
		 $response['surname']=$row['surname'];
		 $response['group_id']=$row['group_id'];
		 $response['debit_credit']=$row['debit_credit'];
		 $response['group_name']=$group_name['group_name'];

		 
	 }else{
		 $response['error'] = true; 
		 $response['message']='Not Logged';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
