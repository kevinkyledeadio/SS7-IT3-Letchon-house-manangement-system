<?php
session_start();
session_destroy();
header("Location: log-in.php");
exit();
