<?php

$pc2 = <<<eot
1|team1|TRUE|123
2|team2|TRUE|123
eot;

$pc2 = str_replace("\r", "", $pc2);
$lines = explode("\n", $pc2);
$i = 1;
foreach($lines as $line)
{
  $line = trim($line);
  if(empty($line))continue;
  $a = explode("|", $line);
  $teams[$i] = $a;
  $i++;
}

function verify($teamid, $password)
{
  global $teams;
  if(empty($password) || $teamid=="team")return false;
  $teamid = str_replace("team", "", $teamid);
  return ($teams[$teamid][3] == $password);
}
?>
