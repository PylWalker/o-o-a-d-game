<?php
class AppMVC {
	//Hàm nhận các tham số từ url để điều khiển 
	public function run(){
		// echo '<pre>';
		// 	print_r($_GET);
		// echo '</pre>';
		$controller = isset($_GET['controller'])? $_GET['controller']:'index';
		$action = isset($_GET['action'])? $_GET['action']:'index';
		// Kiểm tra phân quyền trước khi làm các việc khác
		/*
				if(!$this->CheckACL($controller,$action)){
					// không có quyền vào action hiện tại

					echo "<p style='color: red; text-align:center'>Bạn chưa được cấp quyền sử dụng thao tác này!</p>";
					die();
				}
		*/
		// chuyển tham số url thành tên lớp
		$classController = str_replace('-', ' ', $controller);
		$classController = ucwords($classController);
		$classController = str_replace(' ', '', $classController);
		$classController .= 'Controller';
		// chuyển biến action thành tên action
		$actionName = str_replace('-', ' ', $action);
		$actionName = ucwords($actionName);
		$actionName = str_replace(' ', '', $actionName);
		$actionName .= 'Action';

		$objController = new $classController(); // tạo mới đối tượng controller
		if(!method_exists($objController, $actionName))
			die('Action <b>'. $actionName .'</b> not found!');
		$objController->currentController = strtolower($controller);
		$objController->currentAction = strtolower($action);
		$objController->$actionName(); // lệnh gọi action của đối tượng controller
		$objController->loadLayout();
	}
}