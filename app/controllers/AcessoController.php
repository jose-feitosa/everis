<?php 
	namespace App\Controllers; 
	
	use \App\Models\Acesso; 
	
	use \App\Models\Menu;
	
	use \App\Models\User;
	
	use \App\Models\Roles;
	
	class AcessoController {
	
	public function index($userid) { 

		$mainmenu = Menu::getMainMenu($userid);
		$submenu = Menu::getSubMenu($userid);	
		$userroles = Acesso::getUsersRoles();
		
		\App\View::make('acesso.index', [ 'userroles' => $userroles,'mainmenu' => $mainmenu,'submenu' => $submenu,]);
	} 
 
	public function defineacesso($id)
	{	
		$user = User::selectAll($id)[0];				
		$roles = Roles::getRoles();
		\App\View::make('acesso.defineacesso', ['user' => $user, 'roles' => $roles,]);		
	}

	public function DefiniuAcesso()
	{
		$id = $_POST['userid'];
		$rolesid = $_POST['rolesid'];
		$name = $_POST['rolename'];
		
		if (Acesso::gravandoAcesso($id,$rolesid,$name))
		{
			header('Location: /everis/router_view.php?objeto=acesso&view=index');
			exit;
		}
	}	
}