<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">   
    <link href="<?= BASE;?>public/css/cover.css" rel="stylesheet">
    <title>Tdo-list</title>
    
    
</head>
<body class="text-center bg-image p-5">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="masthead mb-auto">
    <div class="inner">
      <h3 class="masthead-brand">Bloggy</h3>
      <nav class="nav nav-masthead justify-content-center">
        <a class="nav-link active" href="<?=BASE;?>">Home</a>
        <?php if(isset($user)){ ?>
        <a class="nav-link" href="<?=BASE;?>user/profile"><?=$user['username'];?></a>
        <?php }else{ ?>
          <a class="nav-link" href="<?=BASE;?>user/login">Login</a>
        <?php } ?>
       
        <a class="nav-link" href="<?=BASE;?>index/contact">Contact</a>
      </nav>
    </div>
  </header>

  

  
   



    
   
  
  
