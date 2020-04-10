<?php 
	namespace App\Controllers; 
	
	use \App\Models\User; 
	
	use \App\Models\Menu;
	
	class UserController {
	
	public function index($userid) { 

		$mainmenu = Menu::getMainMenu($userid);
		$submenu = Menu::getSubMenu($userid);	
		$users = User::selectAll(); 
		
		\App\View::make('user.index', [ 'users' => $users,'mainmenu' => $mainmenu,'submenu' => $submenu,]);
	} 
 
    public function create()
    {
        \App\View::making('user.create');
    } 
 
    /**
     * Processa o formulário de criação de usuário
     */
    public function store()
    {
		$username = isset($_POST['username']) ? $_POST['username'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;
		
		if (User::save($username, $password)) {
			header('Location: /everis/router_view.php?objeto=user&view=index');
			exit;
		}		
    }
 
    /**
     * Exibe o formulário de edição de usuário
     */
    public function edit($id)
    {
        $user = User::selectAll($id)[0];
 
        \App\View::make('user.edit',[
            'user' => $user,
        ]);
    }
	
	public function login()
	{
		$users = User::login($_POST['login'],$_POST['senha']);
		if (count($users) > 0){			
			$id = 0;
			foreach ($users as $user){
				$id = $user['userid'];
			}			
			
			header('Location: /everis/router_view.php?objeto=sis&view=index&id='.$id);			
			exit;
		}		
		else {
			header('Location: /everis/login.php');
		}
	} 
 
    /**
     * Processa o formulário de edição de usuário
     */
    public function update()
    {
        // pega os dados do formuário
        $id = $_POST['userid'];
        $username = isset($_POST['username']) ? $_POST['username'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;
		
        if (User::update($id, $username, $password))
        {
            header('Location: /everis/router_view.php?objeto=user&view=index');
            exit;
        }
    }
 
    /**
     * Remove um usuário
     */
    public function remove($id)
    {
        if (User::remove($id))
        {
            header('Location: /everis/router_view.php?objeto=user&view=index');
            exit;
        }
    }
}