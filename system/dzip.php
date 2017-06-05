<?php

# Check Path 'isset'
$zn = (isset($_GET['zn']) && $_GET['zn'] != '') ? $_GET['zn'] : die('Path not specified.');

unlink($zn);
echo '<script type="text/javascript">window.close();</script>';

?>