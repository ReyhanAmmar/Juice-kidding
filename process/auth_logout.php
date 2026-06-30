<?php
session_start();
session_unset();    // hapus semua variabel session
session_destroy();  // hancurkan session

header("Location: ../login.php");
exit;