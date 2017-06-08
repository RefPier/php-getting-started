<?php

require_once 'DbOperation.php';
 
 $db = new DbOperation(); 
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $id = isset($_POST['id']) ? $_POST['id'] : '';
	 
	 $db = new DbOperation(); 
	 
	 $result = $db->removeContactsNumber($id);
	 
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
