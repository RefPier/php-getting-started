<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 $item = isset($_POST['item']) ? $_POST['item'] : '';
	 
	 $db = new DbOperation(); 
	 $result = $db->insertItemInShoppingList($group_id, $item);
 
 	if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Item insert';
 	}else{
		 $response['error'] = true;
		 $response['message']='Item not insert';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
