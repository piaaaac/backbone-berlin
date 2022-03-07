<?php

/**
 * Die and inspect variable
 */
function kill ($var, $continue = false) {
  $msg = "<pre>". print_r($var, true) ."</pre>";
  if (isset($continue) && $continue === true) {
    echo $msg;
  } else {
    die($msg);
  }
}


Kirby::plugin("your/plugin", [
  "fieldMethods" => [
    "bool2Text" => function ($field, $y = "Yeppp", $n = "Nooope") {
      $field->value = $field->bool() ? $y : $n;
      return $field; 
    }
  ]
]);