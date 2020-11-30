<?php
    include  'src/templates/header.tpl.php';

    ?>
    <main>
        
    <form class="form" method="POST" action="?url=newtaskaction">
    <legend>
        <p>Fill data please...</p>
        <div class="form-row">
        <input type="text" name="description" placeholder="description" required>
        </div>
        
        <div class="form-row">
        <label for="due_date">Date and time estimated:</label>
        <input type="date" id="due_date" name="due_date" value="<?= date("Y-m-d");?>">
        </div>
        
        <div class="form-row">
        
        <button class="but-add" type="submit">Add...</button>
        </div>
        
    </legend>
    </form>
    </main>

    <?php

        include 'src/templates/footer.tpl.php';