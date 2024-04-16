<?php

function generate_int()
{
  $numero = 4;
  $input = '0123456789abcdefghijklmnopqrstuvwxyz';
  $input_length = strlen($input);
  $random_int = '';
  for ($i = 0; $i < $numero; $i++) {
    $random_num = $input[mt_rand(0, $input_length - 1)];
    $random_int .= $random_num;
    if ($numero == $random_int) {
      //echo $random_int;
      return;
    }
  }
  return $random_int;
}

$ordenCompra = generate_int();


?>
