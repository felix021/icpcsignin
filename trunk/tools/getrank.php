<?php
/*
 * oak比赛结果抓取工具
 *  php命令行运行即可，也可以在浏览器中执行
 *  需要$contest_id
 *  结果保存在当前目录下的txt文本中
 */
$contest_id = "1065";

$out = "";
$url_prefix = "http://acm.whu.edu.cn/oak/contest/contestStanding.jsp?contest_id={$contest_id}&start=";

$pattern = "/<tr class=tr(o|e)>.*<td>(\\d+)<\/td>.*<td>.*<a href=\"\.\.\/status\/userStatus\.jsp\?user_id=(.*)\">.*<\/a>.*<\/td>.*<td>(\\d+)<\/td>.*<td>(.+)<\/td>/isU";

//echo "RANK | ID | AC | PENALTY\n";
for ($i = 0; true; $i += 20){
    $url = $url_prefix . $i;
    $str = file_get_contents($url);
    preg_match_all($pattern, $str, $mat, PREG_SET_ORDER);
    $c = count($mat);
    if($c == 0) break;
    foreach($mat as $t){
        $piece = "{$t[2]}|{$t[3]}|{$t[4]}|{$t[5]}\n";
        $out .= $piece;
        echo $piece;
    }
}

file_put_contents("$contest_id.txt", $out);
echo $out;

?>
