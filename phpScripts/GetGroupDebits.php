<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['error'] = false; 

	 $response['moneySummaries'] = array(); 
	 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 
	 $db = new DbOperation();
	 
	 $contacts = $db->getGroupDebits ($group_id);
	 
	 $c = 0;
	 
	 while($contact = $contacts->fetch_assoc()){
		 $c++;
		 $temp = array();
		 $temp['facebook_id']=$contact['facebook_id'];
		 $temp['name']=$contact['name'];
		 $temp['debit_credit']=$contact['debit_credit'];
		 array_push($response['moneySummaries'],$temp);
		 }
		
	 $response['numberUsers'] = $c;
	 
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
