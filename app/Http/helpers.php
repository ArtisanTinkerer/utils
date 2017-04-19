<?php
/**
 * Created by PhpStorm.
 * User: mick byrne
 * Date: 18/04/2017
 * Time: 08:53
 */


/**
 * Saves the first part of the URL, so we can go back to it later
 */
function storeEntryPoint()
{
    $entryPoint = array_shift((explode(".", $_SERVER['HTTP_HOST'])));
    session(['entryPoint' => $entryPoint]);
}


/**
 * Swaps underscores for spaces
 * and fixes capitilasation
 *
 * @param $headerArray
 * @return array
 */


function fixUnderscores($headerArray){
    $retArray = array();

    foreach($headerArray as $element){
        $retArray[] = ucwords(str_replace("_"," ",$element));
    }

    return $retArray;

}

/**
 * Get the comments from the SQL
 * http://stackoverflow.com/questions/9690448/regular-expression-to-remove-comments-from-sql-statement
 * @param string $string
 * @return mixed|string
 */
function strip_sqlcomment ($string = '') {
    $RXSQLComments = '@(--[^\r\n]*)|(\#[^\r\n]*)|(/\*[\w\W]*?(?=\*/)\*/)@ms';
    return (($string == '') ?  '' : preg_replace( $RXSQLComments, '', $string ));
}

/**
 * This replaces the tokens in the SQL - for the lookups
 * with the tokens and values in the array
 *
 * @param $SQL
 * @param $tokensArray
 */
function insertParams(&$SQL,$tokensArray){

    foreach($tokensArray as $key => $value){

        //now we want to be able to do IN
        //so the param needs to be 123;12;45;12
        //I need to trim the value here

        $trimmedValue = trim($value);

        $parameterArray = explode(";",$trimmedValue);
        $SQLInString = "";

        $sizeOfArray = sizeof($parameterArray);

        for($elementOn = 0; $elementOn < $sizeOfArray; $elementOn++){

            $SQLInString .= "'$parameterArray[$elementOn]'";

            //if we arent on the last one, add a comma
            if($elementOn != $sizeOfArray-1){
                $SQLInString .=",";
            }
        }
        //123456
        // or 123;123;45;

        $SQL = str_replace("{". $key."}", $SQLInString, $SQL);
    }
}
