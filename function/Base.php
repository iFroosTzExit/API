<?php

class Base {
    private string $_module = "";
    private string $_controller = "";
    private string $_action = "";
    private array $_params = array();

    public function __construct() {
        if (!isset($_SERVER['REQUEST_URI'])) return false;
        $this->setParams($_SERVER['REQUEST_METHOD']);
        $this->startURI();
    }

    private function setParams($request_method) {
        $this->verifySecurity($request_method);
        $this->startURI();
        if ($request_method == "GET") {
            $this->_params = $_GET;
        } else if ($request_method == "POST") {
            $json = file_get_contents("php://input");
            $json = (array) json_decode($json);
            $this->_params = $json;
        }
    }

    private function verifySecurity($request_method) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if ($request_method == "GET") {
            if ($user_agent != "system/portal") {
                echo "Falha na validação do Agente do Usuário";
                die();
            }
        } else if ($request_method == "POST") {
            $content_type = $_SERVER['CONTENT_TYPE'];
            if ($user_agent != "system/portal" || $content_type != "application/json") {
                echo "Falha na validação do Agente do Usuário ou Conteúdo Tipo";
                die();
            }
        }
    }

    private function startURI() {
        $url = explode("/", $_SERVER['PATH_INFO']);
        $this->_module = $url[1];
        $this->_controller = $url[2];
        $this->_action = $url[3];
    }

    public function start() {
        $tabela = new Tabela();
        $query = "SELECT * FROM logs.log_sistema ls";
        $tabela->getResultQuery($query);
    }
}