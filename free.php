<?php

session_start();
session_unset(); // $_SESSION = empty
session_destroy(); // delede session id, obj ...
echo 'Cleared session in ' . date('Y-m-d H:i:s');
