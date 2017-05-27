<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['error'] = false; 

	 $response['cleaning_rounds'] = array(); 
	 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 
	 $db = new DbOperation();
	 
	 $rounds = $db->getGroupCleaningRound ($group_id);
	 
	 $c = 0;
	 
	 while($round = $rounds->fetch_assoc()){
		 $c++;
		 $temp = array();
		 $temp['facebook_id']=$round['facebook_id'];
		 $temp['name']=$round['name'];
		 $temp['description']=$round['description'];
		 $temp['done']=$round['done'];
		 array_push($response['cleaning_rounds'],$temp);
		 }
		
	 $response['numberOfEvents'] = $c;
	 
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
