<?php
  function upload($image){
    $image = explode("," , $image);
    $image_decode = base64_decode($image[0]);
    $path =  'images/'.$image[1];
    $file = file_put_contents($path, $image_decode);
    return $image[1].'.jpeg';
  }
?>
