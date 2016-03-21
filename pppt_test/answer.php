<?php
require dirname(__DIR__). '/pppt_lib/autoload.php';
$in = trim(fgets(STDIN));
log::w('$in : '. $in);
log::w('$in type : '. gettype($in));
if(is_numeric($in)) {
    log::w('is_numeric($in) : true');
    if((int)$in < 1) { echo $in, PHP_EOL; return; }
    $r = [];
    for($i = 0; $i < $in; ++$i) {
        $r[] = trim(fgets(STDIN));
        log::w('$r[] : '. end($r));
    }
    echo implode(' && ', $r), PHP_EOL;
    return;
}
log::w('is_numeric($in) : false');
echo $in, PHP_EOL;