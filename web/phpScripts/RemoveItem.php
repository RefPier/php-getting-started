<?php

require_once 'DbOperation.php';
 
 $db = new DbOperation(); 
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 $item = isset($_POST['item']) ? $_POST['item'] : '';
	 
	 $db = new DbOperation(); 
	 
	 $result = $db->removeItem($group_id, $item);
	 
	 if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Item removed successfully';
	}else{
		 $response['error'] = true;
		 $response['message']='Item not removed';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
