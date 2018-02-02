<?php

$string = $argv[1];
if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
    echo "false\n";
} else {
    echo "true\n";
}