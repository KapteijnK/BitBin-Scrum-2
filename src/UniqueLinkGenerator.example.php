<?php

function generatelink()
{
    $uniquecode = strtr(base64_encode(openssl_random_pseudo_bytes(16)), "+/=", "XXX");
    $url = '/pagina/view.php?code=' . $uniquecode;             // add url before /pagina/view.php?code=
    return [$uniquecode, $url];
}
