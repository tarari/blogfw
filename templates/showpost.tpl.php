<?php

include 'header.tpl.php';
?>
    <main class="container">
    <article>
    <?php
        if ($data){
            
            echo '<h1>'.stripslashes($data[0]['title']).'</h1>';
            echo stripslashes($data[0]['body']);
        }
    ?>
    </article>
    </main>

<?php
    include 'footer.tpl.php';
    ?>