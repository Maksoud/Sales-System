<?php

namespace App\Lib;
use Cake\Utility\Inflector;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\Utility\Security;
use Cake\I18n\Time;

class Util{   

  /*
  * Gera uma sequência aleatória sem caracteres repetidos.
  * Usa random_int (seguro) e limita o tamanho ao total de caracteres
  * disponíveis; antes, pedir mais que isso causava um loop infinito.
  */
  private static function caracteresUnicos($possible, $length)
  {
        $chars = str_split($possible);

        // embaralhamento Fisher-Yates
        for ($i = count($chars) - 1; $i > 0; $i--) {
            $j = function_exists('random_int') ? random_int(0, $i) : mt_rand(0, $i); // composer.json ainda aceita PHP 5.6
            list($chars[$i], $chars[$j]) = [$chars[$j], $chars[$i]];
        }

        $length = max(0, min((int)$length, count($chars)));

        return implode('', array_slice($chars, 0, $length));
  }

  public static function GerarCodificacao($length = 8)
  {
        return self::caracteresUnicos("0123456789abcdefghjklmnopqrstuvwxyz", $length);
  }

  public static function ToSlug($string = "", $replacement = '-')
  {

      $string = strtolower(Inflector::slug($string, $replacement));

      return $string;
  }


  public static function CompareTwoDatesInDays($date1, $date2)
  {
    
    $days = 0;

    $diff = (strtotime($date1) - strtotime($date2)); // 19522800 segundos
    $days = (int)floor( $diff / (60 * 60 * 24)); // 225 dias    

    return $days;
  }    

  public static function DebugLog($title, $data)
  {

    Configure::write('debug', true);
    Log::write('debug', $title); 
    Log::write('debug', $data);

  } 

  /*
  * Create a hash from string using given method. Fallback on next available method. 
  * If $salt is set to true, the application’s salt value will be used:
  * md5, sha1, sha256
  */
  public static function GerarHash($length = 8, $type = 'sha1') {
    
    $string = self::GerarCodificacao($length);

    $hash = Security::hash($string, $type, true);

    return $hash;  
  }

   public static function GerarProtocolo($length = 8)
   {
        return self::caracteresUnicos("0123456789ABCDEFGHJKLMNOPQRSTUVWXYZ", $length);
    }

}


?>