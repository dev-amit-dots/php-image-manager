<?php

function uploadImage($file,$destination)
{

    move_uploaded_file(

        $file['tmp_name'],

        $destination

    );

}