<?php

namespace App\Lib;

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

class Upload{   

  public $basePath;

  public function __construct() {

    $this->basePath = WWW_ROOT.'files/';
  }

  public function sendFile($post = array(), $name = false, $basePath = null, $replace_repeat_file = false)
  {
      $this->basePath = (@$basePath ? $basePath : $this->basePath);
      $fileName = (@$name ? $name : $post['name']);

      $filePath = $post['tmp_name'];

      $data = [];
      $pathinfo = pathinfo($fileName);
      $fileName = $pathinfo['basename'];
      $fullPath = $this->basePath . DS . $fileName;
      $folder = new Folder($this->basePath, true, 0777);
      
      //If true, case exist the same file in server, don't replace the file
      if ($replace_repeat_file) {  

        $cpt = 1;
        while (file_exists($fullPath)) {
            $fileName = $pathinfo['filename'] . '_' . $cpt . '.' . $pathinfo['extension'];
            $fullPath = $this->basePath . DS . $fileName;
            $cpt++;
        }
      }

      if (move_uploaded_file($filePath, $fullPath)) {
          $file = new File($fullPath);
          $data = [
              'path' => $this->basePath . DS . $file->name,
              'extension' => $file->ext()
          ];
      }

      return $data;           
  }


}


?>