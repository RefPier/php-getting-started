<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
	 $response['users'] = array();
 
	 $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
	 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
	 $description = isset($_POST['description']) ? $_POST['description'] : '';
	 $date = isset($_POST['date']) ? $_POST['date'] : '';
	 $money = isset($_POST['money']) ? $_POST['money'] : '';
	 
	 $db = new DbOperation(); 
	 $result = $db->insertExpense($group_id, $facebook_id, $description, $date, $money);
	 
	 
	 $memberCount = $db->countMembers($group_id);
	 $users = $db->getGroupUsers ($group_id);
	
	 
	 if($memberCount == 0){
		$memberCount =1;}
	 $moneyPerMember = $money/ (float) $memberCount;
	 
	 $updateAll = $db->updateGroupDebits($group_id,$moneyPerMember);
	 	 
	 $updateMe = $db->sumMoney($facebook_id, $money);
	 
	 
	 while($user = $users->fetch_assoc()){
		 $temp = array();
		 $temp['facebook_id']=$user['facebook_id'];
		 array_push($response['users'],$temp);
		 }
 
 	if($result == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Insert';
 	}else{
		 $response['error'] = true;
		 $response['message']= 'error';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
