<?php

namespace App\Core;

class Core{

    public function run(){
        //sistema_Envia_email/login/index
        $Url = '/';
        if(isset($_GET['url'])){
            $Url .= $_GET['url'];
        }

        $Url = $this->CorrigiUltimaBarra($Url);
        $Url = $this->VerificaRota($Url);
        
        

      $params = array();

        if(isset($Url) && $Url != '/'){
            $Url = explode('/',$Url);        
            $currentController = $Url['0'].'Controller';
            array_shift($Url);
            if (isset($Url[0]) && !empty($Url[0])) {
				$currentAction = $Url[0];
				array_shift($Url);
			} else {
				$currentAction = 'index';
			}
            
			if (count($Url) > 0) {
				$params = $Url;
			}
		} else {
			$currentController = 'NotfoundController';
			$currentAction = 'index';
		}
        
		$currentController = ucfirst($currentController);

		$prefix = '\App\Controllers\\';
        var_dump(method_exists($prefix . $currentController, $currentAction));
		if (
			!file_exists('../App/Controllers/' . $currentController . '.php') ||
			!method_exists($prefix . $currentController, $currentAction)
		) {
			$currentController = 'NotfoundController';
			$currentAction = 'index';
		}



	/* 	$newController = $prefix . $currentController;
		$c = new $newController();

		call_user_func_array(array($c, $currentAction), $params); */

    }

    public function CorrigiUltimaBarra($Url){
        $UltimoCaracter = substr($Url, -1);

        if($UltimoCaracter == '/'){
            $Size = strlen($Url);
            $Url = substr($Url, 0, $Size -1);
        }
        return $Url;
    }

    public function VerificaRota($Url){
        global $routes;

        foreach($routes as $UrlRota => $NewUrl){
            $UrlRota = $this->CorrigiUltimaBarra($UrlRota);

            if($Url ==  $UrlRota){
                return $NewUrl;
                break;
            }
        }
    }

}




/* require_once '../vendor/autoload.php';

if($_GET['Url']){
    $Url = explode('/', $_GET['Url']);

    if($Url[0] === 'api'){
        array_shift($Url);

        $service = $Url[0]. 'Controller';
        array_shift($Url);

        $method = $_SERVER['REQUEST_METHOD'];
       
        
        
    }
} */

?>