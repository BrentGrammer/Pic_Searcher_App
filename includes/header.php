<?php ob_start(); //prevents header() errors ?>
<?php session_start(); //this allows access to logged in user data in $_SESSION ?>
<?php include "includes/dbconn.php"; ?>
<?php include "includes/functions.php"; ?>

<!DOCTYPE html>
<html lang="en">

  <head>

      <meta charset="utf-8">
      <!-- meta info For Bootstrap -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <title>Pic Browser</title>
      <!--Font Awesome from Bootstrap CDN  -->
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <!-- additional styling loads last -->
      <link rel='stylesheet' href='main.css' type='text/css' />

  </head>

  <body>
