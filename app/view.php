<?php

namespace App;

/**
 * Classe para gerar uma view da aplicação.
 * É responsável por carregar o template geral e adicionar a view que deve ser exibida
 */
class View
{
    public static function make($viewName, array $customVars = array())
    {
        // cria as variáveis do array $customVars
        extract($customVars);
        
	
        // inclui o template, que vai processar a view na variável $viewName
        require_once viewsPath() . 'template.php';
    }
	
	public static function making($viewName)
	{
		require_once viewsPath() . 'template.php';
	}
}