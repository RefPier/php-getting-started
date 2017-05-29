<?php 
 require_once 'DbOperation.php';
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
	 $myfacebook_id = isset($_POST['myfacebook_id']) ? $_POST['myfacebook_id'] : '';
	 $hisfacebook_id = isset($_POST['hisfacebook_id']) ? $_POST['hisfacebook_id'] : '';
	 $money = isset($_POST['money']) ? $_POST['money'] : '';
	 
	 
	 $db = new DbOperation(); 
	 $sum = $db->sumMoney($myfacebook_id, $money);
	 $subtract = $db->subtractMoney($hisfacebook_id, $money);
 
 	if($sum == 0 && $subtract == 0){
		 $response['error'] = false; 
		 $response['message'] = 'Done';
 	}else{
		 $response['error'] = true;
		 $response['message']= 'Cleaning Schedule not insert';
	 }
 }else{
	 $response['error']=true;
	 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
