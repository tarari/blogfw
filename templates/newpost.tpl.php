<?php
    include  'header.tpl.php';

    ?>
    <script src="https://cdn.tiny.cloud/1/vbcvpmgq7h505j31il8vy72cd5e8mmombwkasppn4i4473o7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
        tinymce.init({
            selector: '#editor',
            width:'100%'
        });
    </script>
    <main class="container">
            <?=$form;?>
            
    </main>
    <script>
                    
    </script>
    
        <?php

        include 'footer.tpl.php';
        ?>