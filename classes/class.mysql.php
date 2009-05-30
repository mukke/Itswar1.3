<?php
/*
$copywrited to Mukke and Numpty and all other devlopers of It's War
@author:	Mukke <mukke@mukke.org>
@descr: 	mysql class page
@version:	Itswar v1.3.1
*/

Class Connection 
{
	private $_link;
	private $db;
	
	
	
	public function __construct() {
		
	
	
	}





	public function __destruct() {
    	mysql_close( $this->_link );
	}



}








?>