<?php
/**
 * Created by PhpStorm.
 * User: hm909
 * Date: 2/15/17
 * Time: 19:00
 */

if (isset($_GET['ids'])) {
    $id = $_GET['ids'];
    //echo $id;
} else {
    echo "Please give IDs";
    $id = '';
}

$ids = explode(",", $id);


if (isset($_GET['h'])) {
    $h = $_GET['h'];
    //echo $id;
} else {
    echo "Please give h<br>";
    $h = 300;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panels</title>
</head>
<body>

<?php
foreach ($ids as $thisid) {
    echo "
<button onclick=\"var ifr=document.getElementsByName('$thisid')[0]; ifr.src=ifr.src;\">Refresh $thisid</button>
<iframe src=\"http://$thisid.ethosdistro.com/\" name=\"$thisid\" width=\"1600\" height=$h frameborder=\"0\" scrolling=\"no\"></iframe>
    ";
}

?>
</body>
</html>