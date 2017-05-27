<?php 
 
 require_once 'DbOperation.php';
 
  
  $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['error'] = false; 

	 $response['events_descriptions'] = array(); 
	 $response['clean_descriptions'] = array(); 
	 
	 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 $date = isset($_POST['date']) ? $_POST['date'] : '';
	 
	 $db = new DbOperation();
	 
	 $events = $db->searchTodayEvents($group_id,$date);
	 $cleanDates = $db->searchCleaningRound($facebook_id);
	 
	 $c = 0;
	 $i = 0;
	 
	 while($event = $events->fetch_assoc()){
		 $c++;
		 $temp = array();
		 $temp['description']=$event['description'];
		 $temp['event_hour']=$event['event_hour'];
		 array_push($response['events_descriptions'],$temp);
		 }
		
	 $response['numberOfEvents'] = $c;
	 
	 while($cleanDate = $cleanDates->fetch_assoc()){
		 $i++;
		 $temp = array();
		 $temp['description']=$cleanDate['description'];
		 array_push($response['clean_descriptions'],$temp);
		 }
	 $response['numberOfClean'] = $i;
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request';
	 
 }
 
 echo json_encode($response);
