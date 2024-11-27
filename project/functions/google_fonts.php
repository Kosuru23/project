<?php
function includeGoogleFont($fontFamilies) {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . PHP_EOL;
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . PHP_EOL;

    foreach ($fontFamilies as $fontFamily) {
        echo '<link href="https://fonts.googleapis.com/css2?family=' . urlencode($fontFamily) . '&display=swap" rel="stylesheet">' . PHP_EOL;
    }
}
?>

<!-- LINK KAHIT ANONG FONTS -->