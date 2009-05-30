<?php
session_start();



//main class


Class Itswar
{

	private $session;
	private $db;
	private $core;
	
	
	public $user;
	public $player;
	public $weapon;
	public $building;
	public $sector;
	public $char;
	public $ai;
	
	
	
	
	public function __construct(){
	
		// core
		$this->session 	= 	new Session;
		$this->db 		= 	new Connection;
		$this->core		=	new Core;
		
		//game objects
		$this->weapon	= 	new Weapon;
		$this->building =	new Building;
		$this->sector	=	new Sector;
		$this->char		=	new Character;
		$this->ai		= 	new AI;
		
		
		//personal objects
		$this->user		= 	new User;
		$this->player	=	new Player;
		
	
	}
	
	
	












}


$itswar = new Itswar;


?>

Please Logon:
<form>
<table>
<tr><td>Username</td><td><input type="text"></td></tr>
<tr><td>Password</td><td><input type="password"</td></tr>
</table>
</form>

