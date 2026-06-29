<?php

function generateImageName($extension)
{

    return uniqid("IMG_").time().".".$extension;

}