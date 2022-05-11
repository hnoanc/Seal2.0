<?php

$FilePath = $_GET['Path'];

    if (file_exists($FilePath))  {
        unlink($FilePath);
    }
?>
