<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['error'] = false; 

	 $response['users'] = array(); 
	 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 
	 $db = new DbOperation();
	 
	 $users = $db->getGroupUsers ($group_id);
	 
	 
	 while($user = $users->fetch_assoc()){
		 $temp = array();
		 $temp['facebook_id']=$user['facebook_id'];
		 $temp['name']=$user['name'];
		 array_push($response['users'],$temp);
		 }
		
	 
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
