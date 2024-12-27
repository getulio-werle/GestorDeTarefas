<?php

// return "selected" to selected task status
function check_status($item, $status)
{
    if (key_exists($status, STATUS_LIST)) {
        if ($item === $status) {
            return 'selected';
        } else {
            return '';
        }
    } else {
        return '';
    }
}

// encrypt values
function encrypt($value)
{
    try {
        $enc = \Config\Services::encrypter();
        return bin2hex($enc->encrypt($value));
    } catch (\Throwable $th) {
        return false;
    }
}

// decrypt values
function decrypt($value)
{
    try {
        $enc = \Config\Services::encrypter();
        return $enc->decrypt(hex2bin($value));
    } catch (\Throwable $th) {
        return false;
    }
}
