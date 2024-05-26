<?php

/**
 * Classe de funções para ser úteis no sistema
 * 
 * @author Evandro Campos Teixeira Pires 
 * @category Funcoes
 */

class Funcoes {

    /**
     * @param mixed $info
     * @return html 
     */
    public static function debug($info) {
        $html = "<div class='container'>";

        if (is_array($info)) {
            $contador = 0;
            foreach ($info as $key => $value) {
                if (is_array($value)) {
                    $html .= "<div class='row'>";
                    $html .= "['{$contador}]<br>";
                    foreach ($value as $key_1 => $value_1) {
                        $html .= "<div class='row'>";
                        $html .= "['{$key_1}'] => {$value_1}<br>";
                        $html .= "</div>";
                    }
                    $html .= "</div>";
                    $contador = $contador + 1;
                } else {
                    $html .= "<div class='row'>";
                    $html .= "['{$key}'] => {$value}<br>";
                    $html .= "</div>";
                }
            }
        } else if (is_string($info) || is_numeric($info)) {
            $html .= "<div class='row'>{$info}</div>";
        } else {
            print_r($info);
            die();
        }

        echo $html;
        die();
    }
}
