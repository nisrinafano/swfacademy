<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?= $title; ?></title>

    <!-- Bootstrap core CSS -->

    <link href="<?= base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url()?>assets/css/forum.css" rel="stylesheet">
    <link href="<?= base_url();?>assets/css/bootstrap-tagsinput.css" rel="stylesheet">

    <link href="<?= base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
    <script>
      tinymce.init({
        selector: '#text-answer'
      });
    </script>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="<?= base_url()?>">SWF Forum</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="kotak-cari" >
              <form method="post" action="<?= base_url().'forum/search'?>">
                <input class="form-control" placeholder="Looking for a topics?" type="text" name="search-term">
                <button class="btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
            </li>
            <li class="nav-item active">
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="<?= base_url()?>landing/lists">Login/Signup</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">