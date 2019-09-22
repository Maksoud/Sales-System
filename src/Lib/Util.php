<?php

namespace App\Lib;
use Cake\Utility\Inflector;
use Cake\Mailer\Email;
use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\Utility\Security;
use Cake\I18n\Time;

class Util{   

  public static function GerarCodificacao($length = 8)
  {  

        // inicializa variables
        $string = "";
        $i = 0;
        $possible = "0123456789abcdefghjklmnopqrstuvwxyz"; 

        // agrega random
        while ($i < $length) {

            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
            
            if (!strstr($string, $char)) { 

                $string .= $char;
                $i++;
            }
        }

        return $string;
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

        // inicializa variables
        $string = "";
        $i = 0;
        $possible = "0123456789ABCDEFGHJKLMNOPQRSTUVWXYZ";  

        // agrega random
        while ($i < $length) {

            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
            
            if (!strstr($string, $char)) { 

                $string .= $char;
                $i++;
            }
        }

        return $string;
    }   

}


?>