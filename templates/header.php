<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  
  <link rel="stylesheet" href="assets/css/style.css">

  <title><?= $page_title; ?></title>
</head>

<body class="bg-light" style="padding-top:70px;">
  <div class="wrapper">
    <div class="myContainer">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="./">
          פורום
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="./"><i class="fas fa-home"></i> בית<span class="sr-only">(current)</span></a>
            </li>
            <?php
              if (is_logged_in()) {
                if ($current_user->get_status() == 2) {
            ?>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      פנל ניהול
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" data-toggle="modal" data-target="#create-forum-modal">צור פורום</a>
                      <a class="dropdown-item" href="manage_forums.php">ניהול פורומים</a>
                    </div>
                  </li>
            <?php
                }
            ?>
                <li class="nav-item">
                  <span class="navbar-text">
                    שלום <?= $current_user->get_first_name() ?> <?= $current_user->get_last_name() ?>
                  </span>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="functions/logout.php"><i class="fas fa-door-open"></i> יציאה</a>
                </li>
            <?php
              } else {
            ?>
                <li class="nav-item">
                  <a href="#" class="nav-link" data-toggle="modal" data-target="#register-modal">
                  <i class="fas fa-user-plus"></i> הרשמה
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link" data-toggle="modal" data-target="#login-modal">
                  <i class="fas fa-sign-in-alt"></i> התחברות
                  </a>
                </li>
            <?php
              }
            ?>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="חיפוש">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> חיפוש</button>
          </form>
        </div>
      </nav>

      <div class="container">
        <?= display_alerts() ?>
      </div>

    </div>
  </div>
  <?php
    if (!is_logged_in()) {
      include SITE_ROOT."/../templates/login.php";
      include SITE_ROOT."/../templates/register.php";
    } elseif ($current_user->get_status() == 2) {
      $action = 'create';
      include SITE_ROOT."/../templates/forum_form.php";
    }
  ?>
  <div class="container">