<?php
function gen_sesskey() {
    $rand = rand(10000, 99000);
    return $rand;
}
?>
