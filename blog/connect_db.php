<?php

  define("HOST", "127.0.0.1");

  define("USER", "root");

  define("PASSWORD", "123456");

  define("DB", "544261");



  function get_db_connection() {

    $connect = new mysqli(HOST, USER, PASSWORD, DB, 3300);

    if ($connect->connect_error) {

      die("Connection failed: " . $connect->connect_error);

    }

    return $connect;

  }

?>