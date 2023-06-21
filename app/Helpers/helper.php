<?php

/**
 * The function returns an error message or "Internal Server Error" depending on the environment.
 * 
 * @param string $errMessage The error message to be returned in case of an error. If no error message is
 * provided, the function will return a default error message.
 * 
 * @return string
 */
function defaultErrorResponse($errMessage = null)
{
    if (config('app.env') == 'local' || config('app.env') == 'development') {
        return $errMessage;
    } else {
        return 'Internal Server Error';
    }
}

/**
 * The function replaces spaces with hyphens and removes special characters from a given string.
 * 
 * @param string $string The input string that needs to be cleaned and formatted.
 * 
 * @return string
 */
function clean($string) 
{
    $string = str_replace(' ', ' ', $string);
    $removeCharacters = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    return str_replace(',', '', $removeCharacters); // remove comma
 }