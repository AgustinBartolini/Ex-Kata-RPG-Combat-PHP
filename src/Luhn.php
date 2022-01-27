<?php

namespace App;

class Luhn {

    // https://exercism.org/tracks/php/exercises/luhn

    function isValid(string $number) {

        // Busco coincidiencias entre el RegExp y el número que se quiere validar. El RegExp es una expresión regular que busca cualquier dígito (número arábigo). Equivalente a [0-9]. Por ejemplo, /\d/ o /[0-9]/. En caso del $, finaliza el bucle cuando no hay match.

        if(!preg_match('/^[\d ]+$/',$number)) {
            return false;
        }

        // Quita los espacios del número de tarjeta de crédito que se de.
        
        $number= str_replace(' ','',$number);

        // Revisa que el string de tarjeta de crédito no esté vacío luego de borrar los espacios.

        if(strlen($number)<=1) {
            return false;
        }
        
        // Paso el string a array, la invierto y por cada número de esa array invertida (para poder leerla de atrás hacia delante), con ayuda del marker duplico un número sí, otro no y así sucesivamente. En caso de que el número sea superior a 9, se le resta 9.

        $marker=0;
        $numberArray=str_split($number);
        $numberArray=array_reverse($numberArray);
        foreach($numberArray as &$number) {

            if($marker==0) {
                $marker=1;
                continue;
            }

            elseif($marker==1) {
                $marker=0;
                $number=2*(int)$number;
                if($number>9) {
                    $number=$number-9;
                }
                $number=(string)$number;
            }
        }

        // Vuelve la array a su orden original y la transforma a string como lo era en un principio.

        $doubledNumber=strrev(implode($numberArray));
    
        // Chequeo si la suma de los valores del string es divisible por 10.

        $sum=0;
        $doubledNumberArray=str_split($doubledNumber);
        foreach($doubledNumberArray as $number) {
            $sum+=(int)$number;
        }

        // Retorno el resultado de la división y su validez.
    
        if($sum%10==0) {
            return true;
        }
        else{
            return false;
        }
    }
}