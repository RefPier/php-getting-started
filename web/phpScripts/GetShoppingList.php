<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['error'] = false; 

	 $response['items'] = array(); 
	 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 
	 $db = new DbOperation();
	 
	 $items = $db->searchItemsInShoppingList ($group_id);
	 
	 $c = 0;
	 
	 while($item = $items->fetch_assoc()){
		 $c++;
		 $temp = array();
		 $temp['item']=$item['item'];
		 array_push($response['items'],$temp);
		 }
		
	 $response['numberOfItems'] = $c;
	 
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
