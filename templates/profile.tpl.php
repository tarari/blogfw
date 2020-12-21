<?php
 include 'header.tpl.php';
 ?>
 <main class="container">
<div class="row">
 <?php if($user){ ?>
   <section class="my-auto">
    <h1>Username: <?= $user['username']; ?></h1>
    <h3>Email:<?= $user['email']; ?></h3>
   </section>
   </div>
   <div class="row">
 
   <button class="btn btn-secondary">Change</button>
   </div>
    <a href="<?=BASE;?>user/dashboard">Back</a>
    <?php }else{ header("Location:".BASE);}
    ?>

 </div>

 </main>
 <?php
    include 'footer.tpl.php';