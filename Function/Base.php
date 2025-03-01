<?php

namespace Api\Function;

class Base {
    private string $_modulo = "";
    private string $_controller = "";
    private string $_action = "";
    private array $_params = array();
    private array $_tipo_request = ['POST', 'GET', 'PUT', 'DELETE', 'PATCH'];
    private bool $_verifica_login = true;

    public function __construct() {
        header('Content-Type: application/json');
        $this->setError("Falha na validação da URL", !isset($_SERVER['REQUEST_URI']), 400);
        $this->verificaRequest();
        $this->verificaSeguranca();
        $this->startURI();
        $this->verificaPermissao();
    }

    public function return($data) {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        die($data);
    }

    //Ajustar pois mudou o mecanismo
    private function setParams() {
        $request_method = $_SERVER['REQUEST_METHOD'];
        if ($request_method == "GET") {
            $this->_params = $_GET;
        } else if ($request_method == "POST") {
            $json = file_get_contents("php://input");
            $json = (array) json_decode($json);
            $this->_params = $json;
        }
    }

    private function verificaRequest() {
        $this->setError("Não foi possível buscar o tipo de request", !in_array($_SERVER['REQUEST_METHOD'], $this->_tipo_request), 401);
    }

    private function verificaSeguranca() {
        $agente = $_SERVER['HTTP_USER_AGENT'] == "sistema";
        $tipo_conteudo = $_SERVER["HTTP_CONTENT_TYPE"] === "application/json";
        $this->setError("Não foi possível validar a segurança da Request", !($agente || $tipo_conteudo), 401);
    }

    private function startURI() {
        $this->setError("Falha na requisição ao Servidor ! Verifique o endereço", !$_SERVER['PATH_INFO'], 500);
        $url = explode("/", $_SERVER['PATH_INFO']);
        $this->setError("Erro ao carregar o módulo de sistema", empty($url[1]), 500);
        $this->setError("Erro ao carregar o controlador de sistema", empty($url[2]), 500);
        $this->setError("Erro ao carregar a action do sistema", empty($url[3]), 500);
        $this->setModulo($url[1]);
        $this->setController($url[2]);
        $this->setAction($url[3]);
    }

    private function verificaPermissao() {
        if ($this->_verifica_login) {
            $token = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
            $this->setError("Falha na Autenticação de Login !", $this->_verifica_login && $this->validaJwt($token[1]));
        }

        $this->return($_SERVER['HTTP_AUTHORIZATION']);
    }

    //Continuar Função de validar Token
    private function validaJwt($token) {
        return true;
    }

    // Geters and Seters
    public function setVerificaLogin($status) {
        $this->_verifica_login = $status;
    }

    public function getVerificaLogin() {
        return $this->_verifica_login;
    }

    private function setModulo($modulo) {
        $this->_modulo = $modulo;
    }

    public function getModulo() {
        return $this->_modulo;
    }

    private function setController($controller) {
        $this->_controller = $controller;
    }

    public function getController() {
        return $this->_controller;
    }

    private function setAction($action) {
        $this->_action = $action;
    }

    public function getAction() {
        return $this->_action;
    }

    //Inicio do Sistema
    public function setError($mensagem, $condicao, $code = 401) {
        if ($condicao) {
            http_response_code($code);
            $info = [
                'mensagem' => $mensagem,
            ];
            die(json_encode($info, JSON_UNESCAPED_UNICODE));
        }
    }

    public function start() {
    }
}
