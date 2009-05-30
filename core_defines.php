<?php

/******************************************************
#
# MECH GAMING CMS by Ruben Decleyn aka Mukke
# This is an Object oriantated project to make gaming
#     development easier.
# If you got hands on this cms and the core only,
#    pls only ask help from the Mech Developers
#    If you have no id who to contact just try
#     mukke@mukke.org
#
# This project is under GNU licence so you may not
#    sell any of the core files of this project 
#    marked with this credit.
######################################################*/

// ALL BASIC CORE DEFINES   define("","");
// everything not core is done from db and tru the cache/define class
// this file must be always in the your root directory of your game
//if you change things in here do it wisly know that most names and paths
// are based on this file

// Speed up the require_once method 
define ("CORE_DEFINES","true");

// set debug on or off
define ("DEBUG",true);


//PATHS
define("ABS_PATH",dirname($_SERVER['SCRIPT_FILENAME'])."/");		// absolute path of the root
define("REL_PATH",str_replace($_SERVER["DOCUMENT_ROOT"],"",dirname($_SERVER['SCRIPT_FILENAME'])."/"));

define("DIR_CACHE","cache/");
define("DIR_CLASSES","classes/");
define("DIR_CONFIG","config/");
define("DIR_INCLUDES","includes/");
define("DIR_TEMPLATES","templates/");
define("DIR_MODULES","modules/");
define("DIR_JS","ajax/");

//page
if(isset($_GET['p'])) define("PID",$_GET['p']);
if(isset($_SESSION['userlvl'])) define("LVLID",$_SESSION['userlvl']);

//FILES
//config
define("FILE_CONFIG_DB","database.php");
//cache															define("FILE_CACHE_",".php");
define("FILE_CACHE_TEMPLATE","template.php");
define("FILE_CACHE_SETTINGS","hard_settings.php");
//classes														define("CLASS_","class_.php");
define("CLASS_CACHE","class_cache.php");
define("CLASS_CONSTANTS","class_constants.php");
define("CLASS_DATA","class_data.php");
define("CLASS_LAYOUT","class_layout.php");
define("CLASS_MYSQL","class_mysql.php");
define("CLASS_DEBUG","class_debug.php");
define("CLASS_AUTH","class_auth.php");
define("CLASS_REG","class_register.php");
define("CLASS_ERROR","class_user_errors.php");
define("CLASS_PHASH","class_password.php");


//TABLE PREFIX
define("DB_PREFIX","");
//TABLES
define("DB_TEMPLATE_SETTINGS","template_settings");
define("DB_TEMPLATES","templates");
define("DB_HARD_SETTINGS","hard_settings");
define("DB_BLOCKS","layout_blocks");
define("DB_MBLOCKS","menu_blocks");
define("DB_MODS","modules");
define("DB_PMODS","page_modules");
define("DB_SMODS","modules_static");
define("DB_MENU","menu");
define("DB_BLOCK_MODS","block_modules");
define("DB_USERS","users");
define("DB_PAGES","pages");
define("DB_LVLS","userlevels");
define("DB_ULVLS","users_lvls");
define("DB_PLAYERS","players");
define("DB_LOG","actions_log");
define("DB_JS","template_js");




?>