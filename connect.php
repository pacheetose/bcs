<?php

$conn = new mysqli('localhost', 'root', '', 'crud');

if (!$conn) {
  die("Connection Failed:" . mysqli_connect_error());
}
