<?php

namespace App\Helpers;

class Tools
{

    public static function flashes(): array
    {

	$flashes = array();

	if(isset($_SESSION['flash']) && !empty($_SESSION['flash'])){

		foreach( $_SESSION['flash'] as $flash ){

			$flashes[] = $flash;

		}

	}

	return $flashes;

    }


    public static function flash($message)
    {
	$_SESSION['flash'][] = $message;
    }


    public static function error($message)
    {
	$_SESSION['errors'][] = $message;
    }


    public static function passwordHash($password): string
    {

	if( $password == null ){

		return null;

	}

	return hash("sha256", $password . SALT);

    }
    
    
    public static function createSeoUrl($seoUrl): string
    {

	return preg_replace("/[^A-Za-z0-9-]/", '', strtolower($seoUrl));

    }


    public static function formatPostcode($postcode): string
    {

	if( ! $postcode){

	/*  If postcode is empty don't format it  */

		return false;

	}

	/*  Remove any spaces from postcode  */

	$postcode = preg_replace("/[^A-Za-z0-9]/", '', $postcode);

	/*  Make it capitals  */

	$postcode = strtoupper($postcode);

	/*  See how many characters are in postcode  */

	$postcodelength = strlen($postcode);

	/*  Put a space before last 3 digits  */

	$postcode = substr_replace($postcode, " ", ($postcodelength - 3), 0);

	return $postcode;

    }


    public static function getFileExtension($fileName): string
    {

	$explodedot = explode('.', $fileName);
	
	$ext = $explodedot[sizeof($explodedot)-1];
	
	$ext = strtolower($ext);
	
	return $ext;

    }






}
