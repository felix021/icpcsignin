<?php

function select_priority($p = 3){
    $s[$p] = "selected=\"selected\"";
    return <<<eot
<select name="priority">
<option {$s[5]} value="5">最高</option>
<option {$s[4]} value="4">高</option>
<option {$s[3]} value="3">普通</option>
<option {$s[2]} value="2">低</option>
<option {$s[1]} value="1">最低</option>
</select>

eot;
}

?>
