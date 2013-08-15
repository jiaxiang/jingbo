<?php
function pl($arr,$size=5) {
  $len = count($arr);
  $max = pow(2,$len);
  $min = pow(2,$size)-1;
  
  $r_arr = array();
  for ($i=$min; $i<$max; $i++){
   $count = 0;
   $t_arr = array();
   for ($j=0; $j<$len; $j++){
    $a = pow(2, $j);
    $t = $i&$a;
    if($t == $a){
     $t_arr[] = $arr[$j];
     $count++;
    }
   }   
   if($count == $size){
        $r_arr[] = $t_arr;    
   }   
  }
  return $r_arr;
 }

 

$pl = pl(array(1,2,3,4,5,6,7),4);

print_r($pl);