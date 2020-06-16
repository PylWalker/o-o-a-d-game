<?php
  class CartItemModel extends Model{
  	public $id;
  	public $game_id;
  	public $quantity;
  	public $account_id;

  	private $tb_name = "cart_items";

  	public function getCartItems(){
  		if(isset($_SESSION['auth'])){
  			$this->account_id = $_SESSION['auth']->id;
  		} else {
  			$this->account_id = 0;
  		}
  		$where = "inner join games on games.id = cart_items.game_id where account_id = $this->account_id group by cart_items.game_id";
  		$sql = "select cart_items.id, sum(cart_items.quantity) as quantity, games.id as game_id, games.title, games.price as game_price, games.image_720_660, games.image_720_932 from $this->tb_name $where";
  		$res = mysqli_query($this->getConn(), $sql);
  		if(mysqli_errno($this->getConn())!=0)
        return "Failed in $sql: ".mysqli_error($this->getConn());
      $dataRes = array();
      while($row = mysqli_fetch_assoc($res)){
        $objGame = new stdClass();
        foreach($row as $field_name =>$value)
          $objGame->$field_name = $value;
        $dataRes[] = $objGame;
      }
      mysqli_free_result($res);
      return $dataRes;
  	}

  	public function addCartItem(){
  		if($this->isInCart() == false){
  			$sql = "insert into $this->tb_name(game_id, quantity, account_id) values($this->game_id, $this->quantity, $this->account_id)";
	  		$res = mysqli_query($this->getConn(), $sql);
	  		if(mysqli_errno($this->getConn())!=0)
	        return "Fail in $sql: ".mysqli_error($this->getConn());
	      $new_id = mysqli_insert_id($this->getConn());
	      return $new_id;
  		} else {
  			$sql = "update $this->tb_name set quantity = $this->tb_name.quantity + $this->quantity where game_id = $this->game_id";
  			$res = mysqli_query($this->getConn(), $sql);
	  		if(mysqli_errno($this->getConn())!=0)
	        return "Fail in $sql: ".mysqli_error($this->getConn());
	      return $this->id;
  		}
  	}

	 	public function isInCart(){
	 		$sql = "select * from cart_items where game_id = $this->game_id and account_id = $this->account_id";
	 		$res = mysqli_query($this->getConn(), $sql);
	 		if(mysqli_errno($this->getConn())!=0)
	      return "Fail in $sql: ". mysqli_error($this->getConn());
	    if(mysqli_num_rows($res) < 1){
	      return false;
	    } else {
	    	return true;
	    }
	  }

	  public function removeCartItem(){
	  	$sql = "delete from $this->tb_name where game_id = $this->game_id and account_id = $this->account_id";
	  	$res = mysqli_query($this->getConn(), $sql);
	  		if(mysqli_errno($this->getConn())!=0)
	        return "Fail in $sql: ".mysqli_error($this->getConn());
      return $this->id;
	  }

    public function updateCartItem(){
      $sql = "update $this->tb_name set quantity = $this->quantity where game_id = $this->game_id and account_id = $this->account_id";
      $res = mysqli_query($this->getConn(), $sql);
        if(mysqli_errno($this->getConn())!=0)
          return "Fail in $sql: ".mysqli_error($this->getConn());
      return $this->id;
    }
 	}
?>