<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['error'] = false; 

	 $response['expenses'] = array(); 
	 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 
	 $db = new DbOperation();
	 
	 $expenses = $db->getGroupExpenses ($group_id);
	 
	 
	 while($expense = $expenses->fetch_assoc()){
		 $temp = array();
		 $temp['name']=$expense['name'];
		 $temp['date']=$expense['buy_date'];
		 $temp['element']=$expense['element'];
		 $temp['cost']=$expense['cost'];
		 array_push($response['expenses'],$temp);
		 }
		
	 
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
