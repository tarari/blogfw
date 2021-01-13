<?php
    include  'header.tpl.php';

    ?>
    <script src="https://cdn.tiny.cloud/1/vbcvpmgq7h505j31il8vy72cd5e8mmombwkasppn4i4473o7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
        tinymce.init({
            selector: '#editor',
            plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
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