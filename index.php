<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="shortcut icon" href="images/favicon_io/favicon.ico" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <title>Home</title>
</head>

<body>
  <!-- import nav-bar and side-bar from images/bar folder -->
  <?php
  include 'bar/nav-bar.php';
  include 'bar/side-bar.php';
  ?>

  <main>
    <?php include 'content-div/logo.php'; ?>
    <?php include 'content-div/track.php'; ?>
    <?php include 'content-div/service.php'; ?>
    <?php include 'content-div/company-banner.php'; ?>
    <?php include 'content-div/footer-section.php'; ?>
  </main>
  <!-- import here footer file from images/bar/footer.php -->
  <?php include 'bar/footer.php'; ?>
</body>

</html>