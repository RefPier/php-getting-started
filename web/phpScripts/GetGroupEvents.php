<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['error'] = false; 

	 $response['events_descriptions'] = array(); 
	 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 $date = isset($_POST['date']) ? $_POST['date'] : '';
	 
	 $db = new DbOperation();
	 
	 $events = $db->searchAllGroupEvents ($group_id,$date);
	 
	 $c = 0;
	 
	 while($event = $events->fetch_assoc()){
		 $c++;
		 $temp = array();
		 
		 $temp['id']=$event['ID'];
		 $temp['description']=$event['description'];
		 $temp['event_date']=$event['event_date'];
		 $temp['event_hour']=$event['event_hour'];
		 array_push($response['events_descriptions'],$temp);
		 }
		
	 $response['numberOfEvents'] = $c;
	 
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
