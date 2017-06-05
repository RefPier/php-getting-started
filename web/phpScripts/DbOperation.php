<?php
 
class DbOperation
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }
 
    //storing token in database 
    public function registerDevice($facebook_id, $firebase_token, $name,$surname,$group_id,$debit_credit){
        if((!$this->isFBIDExist($facebook_id))){
			$stmt = $this->con->prepare("INSERT INTO users (facebook_id,firebase_token,name, surname, group_id, debit_credit) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss",$facebook_id, $firebase_token, $name, $surname,$group_id,$debit_credit);
            if($stmt->execute())
                return 0; //return 0 means success
            return 1; //return 1 means failure
        }else if($this->isFBIDExist($facebook_id)){
			$stmt = $this->con->prepare("UPDATE users SET firebase_token= ? WHERE facebook_id = ?");
            $stmt->bind_param("ss", $firebase_token, $facebook_id);
            if($stmt->execute())
                return 3; //return 3 means success and that this user has already been registered
            return 1; //return 1 means failure
		}else{
            return 2; //returning 2 means facebook_id and firebase_token already exist
        }
    }

	
    //when someone logout removes the firebase_token
    public function removeDevice ($facebook_id){
	if($this->isFBIDExist($facebook_id)){
            $stmt = $this->con->prepare("UPDATE users SET firebase_token='' WHERE facebook_id = ?");
            $stmt->bind_param("s",$facebook_id);
            if($stmt->execute())
                return 0; //return 0 means success
            return 1; //return 1 means failure
        }else{
            return 2; //returning 2 means facebook id doesn't exists
        }
    }
 
    public function storeToken($facebook_id, $firebase_token){
		if($this->isFBIDExist($facebook_id)){
            $stmt = $this->con->prepare("UPDATE users SET firebase_token=? WHERE facebook_id = ?");
            $stmt->bind_param("ss", $firebase_token, $facebook_id);
            if($stmt->execute())
                return 0; //return 0 means success
            return 1; //return 1 means failure
        }else{
            return 2; //returning 2 means facebook id doesn't exists
        }
	}

    //the method will check if a row has a facebook_id but no firebase_token 
    private function isFirebaseTKempty($facebook_id){
        $stmt = $this->con->prepare("SELECT facebook_id FROM users WHERE facebook_id = ? AND firebase_token = '' ");
        $stmt->bind_param("s",$facebook_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
 
    //getting all tokens to send push to all devices
    public function getAllTokens(){
        $stmt = $this->con->prepare("SELECT firebase_token FROM users");
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['firebase_token']);
        }
        return $tokens; 
    }
 
    //getting a specified token to send push to selected device
    public function getTokenByFBID($facebook_id){
        $stmt = $this->con->prepare("SELECT firebase_token FROM users WHERE facebook_id = ?");
        $stmt->bind_param("s",$facebook_id);
        $stmt->execute(); 
        $result = $stmt->get_result()->fetch_assoc();
        return array($result['firebase_token']);        
    }
 
    //getting all the registered devices from database 
    public function getAllDevices(){
        $stmt = $this->con->prepare("SELECT * FROM devices");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result; 
    }
    
    public function controlLogin($firebase_token){
		$stmt = $this->con->prepare("SELECT * FROM users WHERE firebase_token = ?");
		$stmt->bind_param("s",$firebase_token);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result;
	}
	
	public function getDebitAndGroupId($facebook_id){
		$stmt = $this->con->prepare("SELECT group_id, debit_credit FROM users WHERE facebook_id = ?");
        $stmt->bind_param("s",$facebook_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result;   
	}
	
	public function getGroupName($group_id){
		$stmt = $this->con->prepare("SELECT group_name FROM groups WHERE ID = ?");
        $stmt->bind_param("s",$group_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result;  
	}
	
	public function getUserGroupId($facebook_id){
		$stmt = $this->con->prepare("SELECT ID FROM groups WHERE facebook_id = ?");
        $stmt->bind_param("s",$facebook_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result;   
	}
	
	public function updateUserGroupId($facebook_id){
		$result = $this->getUserGroupId($facebook_id);		
		$group_id = $result->fetch_array();

		$stmt = $this->con->prepare("UPDATE users SET group_id= ? WHERE facebook_id = ? ");
		$stmt->bind_param("ss", $group_id["ID"], $facebook_id);
		if($stmt->execute())
			return 1; //return 0 means success
		return 0; //return 1 means failure
        }
        
	
    public function insertGroup($facebook_id,$group_name){
		 if($this->isFBIDExist($facebook_id)){
			$stmt = $this->con->prepare("INSERT INTO groups (facebook_id,group_name) VALUES (?,?)");
            $stmt->bind_param("ss",$facebook_id,$group_name);
            if($stmt->execute()){
				if($this->updateUserGroupId($facebook_id)){
					return 0;
					}
				return 1;
				}
            return 1; //return 1 means failure
        }else{
            return 2; //returning 2 means facebook_id and firebase_token already exist
        }
	}
	
	public function insertInExistingGroup($facebook_id,$group_id){
		if($this->isFBIDExist($facebook_id)){
			$stmt = $this->con->prepare("UPDATE users SET group_id= ? WHERE facebook_id = ?");
            $stmt->bind_param("ss",$group_id,$facebook_id);
            if($stmt->execute())
				return 0;
			return 1; //return 1 means failure
        }else{
            return 2; //returning 2 means facebook_id doesn't exists
        }
	}
        
        //the method will check if facebook_id already exist 
    private function isFBIDexist($facebook_id){
        $stmt = $this->con->prepare("SELECT facebook_id FROM users WHERE facebook_id = ?");
        $stmt->bind_param("s",$facebook_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    
    public function searchAllGroupEvents ($group_id,$date){
		$stmt = $this->con->prepare("SELECT event_date, event_hour, description FROM group_events WHERE group_id = ? AND event_date >= ? ORDER BY event_date, event_hour");
        $stmt->bind_param("ss",$group_id,$date);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
    
    public function searchTodayEvents($group_id,$date){
		$stmt = $this->con->prepare("SELECT event_hour, description FROM group_events WHERE group_id = ? AND event_date = ? ORDER BY event_hour");
        $stmt->bind_param("ss",$group_id,$date);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
	
	public function insertEvent($group_id, $date, $hour, $description){
		$stmt = $this->con->prepare("INSERT INTO group_events (group_id, event_date, event_hour, description) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss",$group_id, $date, $hour, $description);
		if($stmt->execute())
			return 0;
		return 1;
	}
	
	
	private function isCleaninRoundExists($facebook_id){
        $stmt = $this->con->prepare("SELECT who FROM clean_schedule WHERE who = ?");
        $stmt->bind_param("s",$facebook_id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
	public function searchCleaningRound($facebook_id){
		$stmt = $this->con->prepare("SELECT description FROM clean_schedule WHERE who = ? AND  done = false");
        $stmt->bind_param("s",$facebook_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
	
	
	public function insertCleaningRound($group_id, $facebook_id, $description){
		$done = false;
		if(!$this->isCleaninRoundExists($facebook_id)){
			$stmt = $this->con->prepare("INSERT INTO clean_schedule (group_id, who, description, done) VALUES (?,?,?,?)");
			$stmt->bind_param("ssss",$group_id, $facebook_id,$description, $done);
			if($stmt->execute())
				return 0;
			return 1;
		}else{
			$stmt = $this->con->prepare("UPDATE clean_schedule SET description = ?, done = ? WHERE who = ? AND group_id = ?");
            $stmt->bind_param("ssss",$description, $done, $facebook_id, $group_id );
            if($stmt->execute())
				return 0;
			return 1;
		}
	}
    
    public function insertItemInShoppingList($group_id, $item){
		$bought = false;
		$stmt = $this->con->prepare("INSERT INTO shopping_list (group_id, item, bought) VALUES (?,?,?)");
		$stmt->bind_param("sss",$group_id, $item, $bought);
		if($stmt->execute())
			return 0;
		return 1;
	}
	
	public function searchItemsInShoppingList ($group_id){
		
		$stmt = $this->con->prepare("SELECT item FROM shopping_list WHERE group_id = ? AND bought = false ");
        $stmt->bind_param("s",$group_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
	
	public function removeItem($group_id, $item){
		$stmt = $this->con->prepare("UPDATE shopping_list SET bought=true WHERE group_id = ? AND item = ?");
		$stmt->bind_param("ss",$group_id, $item);
		if($stmt->execute())
			return 0;
		return 1; //return 1 means failure
		
	}
	
	public function getGroupCleaningRound ($group_id){
		$stmt = $this->con->prepare("SELECT users.facebook_id, users.name, clean_schedule.description, clean_schedule.done FROM users LEFT OUTER JOIN clean_schedule ON users.group_id = clean_schedule.group_id AND users.facebook_id = clean_schedule.who WHERE users.group_id = ?");
        $stmt->bind_param("s",$group_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
	
	public function setCleanRound($facebook_id){
		$stmt = $this->con->prepare("UPDATE clean_schedule SET done=true WHERE who = ?");
		$stmt->bind_param("s",$facebook_id);
		if($stmt->execute())
			return 0;
		return 1; //return 1 means failure
	}
	
	public function insertContactsNumber($group_id, $contact_name, $contact_number){
		$stmt = $this->con->prepare("INSERT INTO contacts_numbers (group_id, contact_name, contact_number) VALUES (?,?,?)");
		$stmt->bind_param("sss",$group_id, $contact_name, $contact_number);
		if($stmt->execute())
			return 0;
		return 1;
	}
	
	public function removeContactsNumber($group_id, $contact_name, $contact_number){
		$stmt = $this->con->prepare("DELETE FROM contacts_numbers WHERE group_id=? AND contact_name=? AND contact_number=?");
		$stmt->bind_param("sss",$group_id, $contact_name, $contact_number);
		if($stmt->execute())
			return 0;
		return 1;
	}
	
	public function getGroupContacts ($group_id){
		$stmt = $this->con->prepare("SELECT contact_name, contact_number FROM contacts_numbers WHERE group_id = ?  ORDER BY contact_name");
        $stmt->bind_param("s",$group_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
	
	public function getGroupDebits ($group_id){
		$stmt = $this->con->prepare("SELECT facebook_id, name, debit_credit FROM users WHERE group_id = ?  ORDER BY name");
        $stmt->bind_param("s",$group_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
	
	public function getGroupUsers ($group_id){
		$stmt = $this->con->prepare("SELECT facebook_id, name FROM users WHERE group_id = ?  ORDER BY name");
        $stmt->bind_param("s",$group_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
	
	public function sumMoney($myfacebook_id, $money){
		$stmt = $this->con->prepare("UPDATE users SET debit_credit = debit_credit + ? WHERE facebook_id = ?");
		$stmt->bind_param("ss",$money, $myfacebook_id);
		if($stmt->execute())
			return 0;
		return 1;
	}
	
	public function subtractMoney($hisfacebook_id, $money){
		$stmt = $this->con->prepare("UPDATE users SET debit_credit = debit_credit - ? WHERE facebook_id = ?");
		$stmt->bind_param("ss",$money, $hisfacebook_id);
		if($stmt->execute())
			return 0;
		return 1;
	}
	
	public function insertExpense($group_id, $facebook_id, $description, $date, $money){
		$stmt = $this->con->prepare("INSERT INTO money (group_id, who, buy_date,element, cost) VALUES (?,?,?,?,?)");
		$stmt->bind_param("sssss",$group_id, $facebook_id,$date, $description, $money);
		if($stmt->execute())
			return 0;
		return 1;
	}
	
	public function countMembers($group_id){
		$stmt = $this->con->prepare("SELECT facebook_id FROM users WHERE group_id = ?");
		$stmt->bind_param("s",$group_id);
		$stmt->execute(); 
		$stmt->store_result();
		$numrows = $stmt->num_rows;
		
		$stmt->free_result();
		$stmt->close();
        return $numrows;
	}
	
	public function updateGroupDebits($group_id,$moneyPerMember){
		$stmt = $this->con->prepare("UPDATE users SET debit_credit = debit_credit - ? WHERE group_id = ?");
		$stmt->bind_param("ss",$moneyPerMember, $group_id);
		if($stmt->execute())
			return 0;
		return 1;
	}
	
	public function getGroupExpenses ($group_id) {
		$stmt = $this->con->prepare("SELECT users.name, money.buy_date, money.element, money.cost  FROM users CROSS JOIN money on users.facebook_id = money.who  WHERE money.group_id = ?  ORDER BY money.buy_date");
        $stmt->bind_param("s",$group_id);
        $stmt->execute(); 
        $result = $stmt->get_result();
        return $result; 
	}
}
