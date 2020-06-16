<?php
    class GameModel extends Model{
    	public $id;
    	public $title;
        public $price;
        public $release_date;
        public $summary;
        public $features;
        public $rating;
        public $short_name;
        public $image_720_932;
        public $image_720_660;

    	private $tb_name = 'games';

    	public function getFiveNewGames(){
    		$order = " ORDER BY games.release_date DESC limit 5";
    		$sql = "SELECT * FROM $this->tb_name $order";
    		$res = mysqli_query($this->getConn(), $sql);
            if(mysqli_errno($this->getConn())!=0)
                return "Failed: ". mysqli_error($this->getConn());

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

        public function getEightNewGames(){
            $order = " ORDER BY games.release_date DESC limit 8";
            $sql = "SELECT * FROM $this->tb_name $order";
            $res = mysqli_query($this->getConn(), $sql);
            if(mysqli_errno($this->getConn())!=0)
                return "Failed: ". mysqli_error($this->getConn());

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

        public function getGameDetail(){
            $where = "WHERE games.id = $this->id";
            $sql = "SELECT * FROM $this->tb_name $where";
            $res = mysqli_query($this->getConn(), $sql);
            if(mysqli_errno($this->getConn())!=0)
                return "$sql Failed: ". mysqli_error($this->getConn());
            $dataRes = mysqli_fetch_assoc($res);
            return $dataRes;
        }

        public function getAllGames($page){
            $offset = 9*($page - 1);
            $sql = "SELECT * FROM $this->tb_name LIMIT 9 OFFSET $offset";
            $res = mysqli_query($this->getConn(), $sql);
            if(mysqli_errno($this->getConn())!=0)
                return "Failed: ". mysqli_error($this->getConn());

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

        public function getAllGenres(){
            $sql = "SELECT * FROM genres";
            $res = mysqli_query($this->getConn(), $sql);
            if(mysqli_errno($this->getConn())!=0)
                return "Failed: ". mysqli_error($this->getConn());

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

        public function getMinAndMaxPrice(){
            $sql = "SELECT MIN(price) as min, MAX(price) as max FROM $this->tb_name";
            $res = mysqli_query($this->getConn(), $sql);
            if(mysqli_errno($this->getConn())!=0)
                return "Failed: ". mysqli_error($this->getConn());
            $dataRes = array();
            while($rows = mysqli_fetch_assoc($res)){
                $dataRes[] = $rows['min'];
                $dataRes[] = $rows['max'];
            }
            return $dataRes;
        }

        public function getGamesCount(){
            $sql = "SELECT count(id) as count FROM $this->tb_name";
            $res = mysqli_query($this->getConn(), $sql);
            if(mysqli_errno($this->getConn())!=0)
                return "$sql Failed: ". mysqli_error($this->getConn());
            $dataRes = mysqli_fetch_assoc($res);
            return $dataRes;
        }
    }
?>