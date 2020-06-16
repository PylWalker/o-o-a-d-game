<?php
class IndexController extends Controller{
	public function IndexAction(){
		$objModelGame = new GameModel();
  	$listFiveNewGames = $objModelGame->getFiveNewGames();
  	$this->view->listFiveNewGames = $listFiveNewGames;
  	$listEightNewGames = $objModelGame->getEightNewGames();
  	$this->view->listEightNewGames = $listEightNewGames;
  	$objModelCartItem = new CartItemModel();
  	$listCartItems = $objModelCartItem->getCartItems();
  	$this->view->listCartItems = $listCartItems;
	}

	public function GameDetailAction(){
		$objModelCartItem = new CartItemModel();
		$listCartItems = $objModelCartItem->getCartItems();
  	$this->view->listCartItems = $listCartItems;
		$objModelGame = new GameModel();
		if(isset($_GET['id'])){
			$objModelGame->id = $_GET['id'];
			$res = $objModelGame->getGameDetail();
			$this->view->gameDetail = $res;
		}
	}

	public function LoginAction(){
		$objModelCartItem = new CartItemModel();
		$listCartItems = $objModelCartItem->getCartItems();
  	$this->view->listCartItems = $listCartItems;
		$this->view->redirect = $_SERVER['HTTP_REFERER'];
		$objModelAccount = new AccountModel();
		if(isset($_POST['email'])&&isset($_POST['password'])){
			$objModelAccount->email = $_POST['email'];
			$objModelAccount->password = $_POST['password'];
			$res = $objModelAccount->login();
			if(is_a($res,'stdClass')){
				unset($res->password);
				$_SESSION['auth'] = $res;
				// header('Location:'.base_path);
				// $url = $_SERVER['HTTP_REFERER'];
				$url = $_SESSION['redirect'];
				header("Location: $url");
			}else{
				$this->view->err = array();
				$this->view->err[] = $res;
				$this->view->err[] = $objModelAccount->email;
				$this->view->err[] = $objModelAccount->password;
			}
		}
	}

	public function LogoutAction(){
		session_unset();
		// header("Location:?action=".substr($_SERVER['REQUEST_URI'], 23));
		// header('Location: ?action=login');
		$url = $_SERVER['HTTP_REFERER'];
		header("Location: $url");
	}

	public function AddCartItemAction(){
		$objModelCartItem = new CartItemModel();
		if(isset($_GET['game_id']) && isset($_GET['quantity'])){
			$objModelCartItem->game_id = $_GET['game_id'];
			$objModelCartItem->quantity = $_GET['quantity'];
			$objModelCartItem->account_id = $_SESSION['auth']->id;
			$res = $objModelCartItem->addCartItem();
			$this->view->addCartItemStatus = $res;
		}
	}

	public function CartAction(){
		$objModelCartItem = new CartItemModel();
		$listCartItems = $objModelCartItem->getCartItems();
  	$this->view->listCartItems = $listCartItems;
	}

	public function CheckOutAction(){
		$objModelCartItem = new CartItemModel();
		$listCartItems = $objModelCartItem->getCartItems();
  	$this->view->listCartItems = $listCartItems;
	}

	public function RemoveCartItemAction(){
		$objModelCartItem = new CartItemModel();
		if(isset($_GET['game_id']) && isset($_GET['account_id'])){
			$objModelCartItem->game_id = $_GET['game_id'];
			$objModelCartItem->account_id = $_GET['account_id'];
			$res = $objModelCartItem->removeCartItem();
			$this->view->removeCartItemStatus = $res;
		}
	}

	public function UpdateCartItemAction(){
		$objModelCartItem = new CartItemModel();
		if(isset($_GET['game_id']) && isset($_GET['account_id']) && isset($_GET['quantity'])){
			$objModelCartItem->game_id = $_GET['game_id'];
			$objModelCartItem->account_id = $_GET['account_id'];
			$objModelCartItem->quantity = $_GET['quantity'];
			$res = $objModelCartItem->updateCartItem();
			$this->view->updateCartItemStatus = $res;
		}
	}

	public function GamesAction(){
		$objModelCartItem = new CartItemModel();
		$listCartItems = $objModelCartItem->getCartItems();
  	$this->view->listCartItems = $listCartItems;
		$objModelGame = new GameModel();
		if(isset($_GET['page'])){
			$page = $_GET['page'];
		} else {
			$page = 1;
		}
		$listAllGames = $objModelGame->getAllGames($page);
		$this->view->listAllGames = $listAllGames;
		$listAllGenres = $objModelGame->getAllGenres();
		$this->view->listAllGenres = $listAllGenres;
		$minAndMaxPrice = $objModelGame->getMinAndMaxPrice();
		$this->view->minAndMaxPrice = $minAndMaxPrice;
		$gamesCount = $objModelGame->getGamesCount();
		$this->view->gamesCount = $gamesCount;
	}
}