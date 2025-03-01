<?php

class Tabela extends Base {
    private $_host = "localhost";
    private $_name = "postgres";
    private $_port = "5432";
    private $_user = "postgres";
    private $_password = "Eacampos77@";

    private function openConnetion() {
        $server = "host={$this->_host} port={$this->_port} dbname={$this->_name} user={$this->_user} password={$this->_password}";
        $db_connect = pg_connect($server) or die("Falha ao conectar ao banco de dados");
        return $db_connect;
    }

    private function closeConnetion($db_connect) {
        pg_close($db_connect);
    }

    private function execute_query($query) {
        $db_connect = $this->openConnetion();
        $query_pg = pg_query($db_connect, $query);
        $dados = pg_fetch_all($query_pg);

        $this->closeConnetion($db_connect);

        if (!$dados) {
            echo "An error occurred.\n";
            exit;
        }

        return $dados;
    }

    public function getResultQuery(string $query) {
        $query = "select * from logs.log_sistema ls";
        $result = $this->execute_query($query);
        Funcoes::debug($result);
    }
}
