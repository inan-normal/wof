<?php
session_start();
session_destroy();
header("Location: ana.php");
exit;
