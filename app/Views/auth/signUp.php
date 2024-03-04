<?php

    echo form_open('create_user.php', ['id' => 'frmUsers']);

    echo form_input(['type' => 'text', 'name' => 'name']);

    echo form_input(['type' => 'email', 'name' => 'email']);

    echo form_input(['type' => 'password', 'name' => 'password']);

    echo form_submit('btnSubmit', 'Registrar');




?>

<?php
    echo form_close();
?>