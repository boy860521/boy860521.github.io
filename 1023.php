<?php
function my_own_hash($input)
{
  $magic1 = 1345345333;
  $magic2 = 0x12345671;
  $sum = 7;  $tmp = null;
  $len = strlen($input);
  for ($i = 0; $i < $len; $i++) {
    $byte = substr($input, $i, 1);
    if ($byte == ' ' || $byte == "\t")
        continue;
    $tmp = ord($byte);
    $magic1 ^= ((($magic1 & 63) + $sum) * $tmp) + (($magic1 << 8) & 0xFFFFFFFF);
    $magic2 += (($magic2 << 8) & 0xFFFFFFFF) ^ $magic1;
    $sum += $tmp;
  }
  $out_a = $magic1 & ((1 << 31) - 1);
  $out_b = $magic2 & ((1 << 31) - 1);
  $output = sprintf("%08x%08x", $out_a, $out_b);
  return $output;
}

$guess = "AAAAAA";
$len = 6;
$flag = true;
while($flag){
  if(my_own_hash($guess) == "1631e40f50ad3eee"){
    echo $guess;
    break;
  }
  $temp = ord($guess[0]);
  $temp++;
  $guess[0] = chr($temp);
  if($temp == 123){
    for($i = 0; $i < $len; $i++){
      if($guess[$i] == '{'){
        $guess[$i] = 'A';
        if($i < $len-1) $guess[$i+1] = chr((ord($guess[$i+1])) + 1);
        else $flag = false;
      }
    }
  }
}
if(!$flag) echo "Not found!" . date("h:i:sa");
?>