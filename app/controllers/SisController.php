<?php 
	namespace App\Controllers; 
	
	use \App\Models\User; 
	
	use \App\Models\Menu;
	
	class SisController {
	
	public function index($userid) {	

		session_start();
		if ($_SESSION['acessou'] == "S"){
			$mainmenu = Menu::getMainMenu($userid);
			$submenu = Menu::getSubMenu($userid);
			\App\View::make('sis.index', ['mainmenu' => $mainmenu,'submenu' => $submenu,]);
		}
		else {
			header('Location: /everis/login.php');
			exit;
		}			
	} 
}