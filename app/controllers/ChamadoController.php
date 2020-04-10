<?php 
	namespace App\Controllers; 
	
	use \App\Models\User; 
	
	use \App\Models\Menu;
	
	use \App\Models\Chamado;
	
	class ChamadoController {
	
	public function cliente($userid) { 

		$mainmenu = Menu::getMainMenu($userid);
		$submenu = Menu::getSubMenu($userid);	
		$chamados = Chamado::selectRolesClientes($userid); 
		
		\App\View::make('chamado.cliente', [ 'chamados' => $chamados,'mainmenu' => $mainmenu,'submenu' => $submenu,'user' => $userid,]);
	} 
	
	public function funcionario($userid){
		$mainmenu = Menu::getMainMenu($userid);
		$submenu = Menu::getSubMenu($userid);	
		$chamados = Chamado::selectRolesFuncionario($userid);
		
		\App\View::make('chamado.funcionario', [ 'chamados' => $chamados,'mainmenu' => $mainmenu,'submenu' => $submenu,'user' => $userid,]);		
	}
 
    public function create($iduser)
    {
       \App\View::make('chamado.create',[
            'clienteid' => $iduser,
        ]);		
    } 
	
	public function lido($idchamado)
	{
		if (Chamado::marcaComoLido($idchamado)){
			header('Location: /everis/router_view.php?objeto=chamado&view=cliente');
			exit;
		}
	}	
    
	public function store()
    {
		$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
		$comentario = isset($_POST['comentario']) ? $_POST['comentario'] : null;
		$idcliente = $_POST['clienteid'];
		
		if (Chamado::save($descricao, $comentario,$idcliente)) {
			header('Location: /everis/router_view.php?objeto=chamado&view=cliente');
			exit;
		}		
    }
	
	public function fecharAtendimento($idchamado)
	{
		$chamados = Chamado::chamadoFull($idchamado);
	
        \App\View::make('chamado.fechar',[
            'chamados' => $chamados,			
        ]);		
	}
	
	public function iniciarAtendimento($idchamado,$idfuncionario)
	{
		
		$chamados = Chamado::chamadoFull($idchamado);
	
        \App\View::make('chamado.inicio',[
            'chamados' => $chamados,
			'funcionario' => $idfuncionario,
        ]);	
	}
	
	public function fechar()
	{
		$idchamado = $_POST['chamadoid'];
		$solucao = $_POST['solucao'];
		
		if (Chamado::fechaatendimento($solucao,$idchamado))
		{
			header('Location: /everis/router_view.php?objeto=chamado&view=funcionario');
			exit;
		}
	}
	
	public function iniciar()
	{
		$idchamado = $_POST['chamadoid'];
		$funcionario = $_POST['funcionarioid'];
		$obs = $_POST['analise'];
				
		if (Chamado::iniciaatendimento($obs,$funcionario,$idchamado))
		{
			header('Location: /everis/router_view.php?objeto=chamado&view=funcionario');
			exit;
		}
	}
    
	/*
	public function edit($id)
    {
        $user = User::selectAll($id)[0];
 
        \App\View::make('user.edit',[
            'user' => $user,
        ]);
    }
	
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
    }*/ 
}