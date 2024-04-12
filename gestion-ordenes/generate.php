<?php 

function generate_int(){
  $numero = 5;
  $input = '0123456789';
  $input_length = strlen($input);
  $random_int = '';
  for ($i = 0; $i < $numero; $i++ ) {
    $random_num = $input[mt_rand(0, $input_length -1)];
    $random_int .= $random_num;
  }
  return $random_int;

}
echo generate_int();

?>