<?php

require_once 'DbOperation.php';
 
 $db = new DbOperation(); 
 $response = array(); 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $facebook_id = isset($_POST['facebook_id']) ? $_POST['facebook_id'] : '';
 
 $db = new DbOperation(); 
 
 $result = $db->removeDevice($facebook_id);
 
 if($result == 0){
 $response['error'] = false; 
 $response['message'] = 'Device removed successfully';
 }elseif($result == 2){
 $response['error'] = true; 
 $response['message'] = 'Device does not exists';
 }else{
 $response['error'] = true;
 $response['message']='Device not removed';
 }
 }else{
 $response['error']=true;
 $response['message']='Invalid Request...';
 }
 
 echo json_encode($response);
