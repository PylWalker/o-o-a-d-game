<?php
    class AccountModel extends Model{
    	public $id;
    	public $email;
      public $password;

    	private $tb_name = 'accounts';

      public function login(){
        $sql = "SELECT * FROM $this->tb_name WHERE email = '$this->email'";
        $res = mysqli_query($this->getConn(), $sql);
        if(mysqli_errno($this->getConn())!=0)
          return "Failed: ". mysqli_error($this->getConn());
        if(mysqli_num_rows($res)!=1){
          return "Wrong Email";
        }
        $row = mysqli_fetch_assoc($res);
        if($row['password'] != $this->password){
          return "Wrong Password";
        }
        $obj = new stdClass();
        foreach($row as $field=>$value){
          $obj->$field = $value;
        }
        return $obj;
      }
    }
?>