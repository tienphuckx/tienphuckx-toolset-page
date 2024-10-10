<?php
// response_messages.php

define("EMAIL_NOT_EXIST", json_encode(array(
    "status" => 404,
    "message" => "Email does not exist"
)));

define("PASSWORD_INCORRECT", json_encode(array(
    "status" => 401,
    "message" => "Incorrect password"
)));

define("LOGIN_SUCCESS", json_encode(array(
    "status" => 200,
    "message" => "Login successful",
    // Optionally include dynamic data, this part will need to be updated at runtime
    "data" => array("email" => "")
)));

define("ACCOUNT_DISABLED", json_encode(array(
    "status" => 403,
    "message" => "Your account is disabled"
)));

define("DB_CONNECTION_ERROR", json_encode(array(
    "status" => 500,
    "message" => "Can't connect to Database!"
)));

define("EMPTY_CREDENTIALS", json_encode(array(
    "status" => 400,
    "message" => "Email or Password cannot be empty"
)));
define("QUERY_PREPARE_ERROR", json_encode(array(
    "status" => 501,
    "message" => "Query prepare error."
)));

?>
