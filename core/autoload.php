<?php
	function myAutoLoad($className){
		// echo $className;
		// thứ tự ưu tiên nhúng file: controller, model, library
		//1. Kiểm tra controller
		$file_path = controller_path .'/'.$className.'.php';
		// giả định là tạo đối tượng controller 
		if(file_exists($file_path))
			require_once $file_path; 
		else{
			// class vừa tạo không phải là controller
			$file_path = model_path .'/'.$className.'.php';
			
			if(file_exists($file_path))
				require_once $file_path;
			else{
				$file_path = app_path .'/core/'.$className.'.php';
				if(file_exists($file_path))
					require_once $file_path;
				else{
					$file_path = app_path .'/library/'.$className.'.php';
					echo $file_path;	
					if(file_exists($file_path))
						require_once $file_path;
					else
						die("Class <b>$className</b> not found!");
				}
			}
		}
	}
	spl_autoload_register('myAutoLoad');
?>