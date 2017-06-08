<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['error'] = false; 

	 $response['contacts'] = array(); 
	 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 
	 $db = new DbOperation();
	 
	 $contacts = $db->getGroupContacts ($group_id);
	 
	 $c = 0;
	 
	 while($contact = $contacts->fetch_assoc()){
		 $c++;
		 $temp = array();
		 $temp['id']=$contact['ID'];
		 $temp['contact_name']=$contact['contact_name'];
		 $temp['contact_number']=$contact['contact_number'];
		 array_push($response['contacts'],$temp);
		 }
		
	 $response['numberOfContacts'] = $c;
	 
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
