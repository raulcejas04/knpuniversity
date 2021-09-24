<?php
if (function_exists('mysqli_connect')) {
    echo "- MySQL <b>is installed</b>.<br>";
} else  {
    echo "- MySQL <b>is not</b> installed.<br>";
}
?>
