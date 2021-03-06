<?php
/**
 * Created by PhpStorm.
 * User: zachery
 * Date: 3/14/2016
 * Time: 12:57 PM
 */

function cleanInput($input)
{
    $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
    );
    $output = preg_replace($search, '', $input);
    return $output;
}

function sanitize($input)
{
    $output = "";
    if (is_array($input)) {
        foreach ($input as $var => $val) {
            $output[$var] = sanitize($val);
        }
    } else {
        $input = stripslashes($input);
        $input = cleanInput($input);
        $output = $input;
    }
    filter_var($output, FILTER_SANITIZE_STRING);
    return $output;
}

// Use this to clean up the post vars from the form a bit
function get_post_var($var)
{
    if (isset($_POST[$var])) {
        $val = $_POST[$var];
        return sanitize($val);
    } else {
        return null;
    }
}

function get_get_var($var)
{
    if (isset($_GET[$var])) {
        return sanitize($_GET[$var]);
    } else {
        return '';
    }
}

//printArray($_POST);
function printArray($array)
{
    echo '<code>';
    foreach ($array as $key => $value) {
        echo "$key => $value<br />";
        if (is_array($value)) { //If $value is an array, print it as well!
            printArray($value);
        }
    }
    echo '</code>';
}

// Function for basic field validation (present and neither empty nor only white space
function IsNullOrEmptyString($question)
{
    return (!isset($question) || trim($question) === '');
}

function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}