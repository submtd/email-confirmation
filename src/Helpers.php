<?php

function parseMessage($message, $data = [])
{
    $message = config($message, $message);
    return view(['template' => $message], $data);
}
