<?php
define('INDEX0RVERSION', '0.9');
################################################################################
## Project Name: index0r
## Author: Phillip Metzger (phillip.metzger@gmail.com) (http://0zz.org/)
##
## Version: 0.9;
## Modified: 2/24/2007 2:46:34 PM
################################################################################
/*******************************************************************************

*** INSTALL ***

1. Extract everything in to the root directory you want to list.
2. Modify configurations
3. Call with:

     $directory_list = new index0r;
     $directory_list->init();

*** NOTES ***
     CSS
      - Alternating row classes:
           .alt_row1
           .alt_row2

      - if html="on" style is manually created. Other wise it must be
        specified manually.

     Complete Class List
      - .index0rLink
      - .index0rPathLink
      - .Index0rP
      - .index0rH4
      - .index0rH2
      - .index0rTable
      - .index0rTable span

*******************************************************************************/
############################## CONFIGURATIONS #################################

   // Generate <html> <head> <title> <body> tags
   define("index0rHTML", 'on'); // on/off
   
   // HTML Title before path
   define("index0rHTMLTitle", "Index of: ");

   // Width of <table>
   define("index0rTableWidth", '100%');

   // Display working path. Not recommened to leave on during public use.
   define("index0rDebug", 'off'); // on/off

   // Full root path to directory (ie: /www/data/docs/user.com/public)
   // Use forward slashes ALL PLATFORMS
   // (NO trailing slash)
   define("index0rDirectoryRoot", '.');

   // URL)
   // Example 1: :http://domain.com/directory
   // Example 2: http://domain.com/directory/index0r.php
   define("index0rHomepage", '.'); //  (no trailing slash)

   // If homepage and url to file are different. Exmple: homepage is
   // http://user.com/public/files but directory_root is //user.com/downloads
   // if directory root and homepage are the same file_url should be the same as
   // homepage.
   define("index0rFileUrl", '.'); // (no trailing slash)

   // http path to images
   define("index0rImgSrc", './index0r_img');

   // Alternating row color;
   define("index0rAltColor", 'on'); // on/off
   define("index0rAltColor1", '#F2F2F2');
   define("index0rAltColor2", '#E6E6E6');

   // Sort all directories first before files
   define("index0rOrder", 'on'); // on/off

   // blacklist file names and directories so they will not show
   $index0rBlacklist = Array(
                        ".",
                        "..",
                        "index.php",
                        "index0r_img",
                        "Thumbs.db",
                        ".htaccess",
                        ".htpasswd",
                        ".plan"
                       );

   // error message when directory has failed to open or directory is empty
   define("index0rFailedMsg", "Error 666: Directory not found or directory is empty.");

   // cut name at XX length
   define("index0rMaxLength", 20);

   // format modified date is displayed uses date() function
   // http://php.net/manual/en/function.date.php
   define("index0rDateFormat", "F d Y h:i:s");

   // file type icon list key by file extension (IE: file.exe image is found by key exe)
   $index0rFileTypes = Array(
	         'dir' => 'directory.png',
                 'jpg' => 'image.png',
                 'gif' => 'image.png',
                 'png' => 'image.png',
                 'exe' => 'binary.png',
                 'txt' => 'text.png',
                 'zip' => 'archive.png',
                 'rar' => 'rar.gif',
                 'gz' => 'archive.png',
                 'tar' => 'archive.png',
                 'htm' => 'html.png',
                 'html' => 'html2.png',
                 'php' => 'php.png',
                 'css' => 'text.png',
                 'iso' => 'iso.png',
                 'rpm' => 'rpm.png',
                 'pdf' => 'adobe_pdf.png',
                 'xls' => 'excel.png',
                 'wmv' => 'video.png',
                 'wav' => 'video.png',
                 'asf' => 'video.png',
                 'mpg' => 'video.png',
                 'mov' => 'video.png',
                 'ini' => 'text.png',
                 'psd' => 'psd.png',
                 'plan' => 'plan.png',
                 'mp3' => 'mp3.gif',
                 'bat' => 'bat.gif',
                 'avi' => 'video.png',
                 'md5' => 'key.gif',
                 'asc' => 'key.gif',
                 'cpp' => 'c.gif',
                 'c' => 'c.gif',
                 'py' => 'py.gif',
                 'js' => 'js.gif',
                 'psp' => 'psp.gif'
                );

  // Advanced Settings
  $index0rSettings['loggin'] = "on"; // on/off
  $index0rSettings['error_reporting'] = "on"; // on/off
  
  // KEEP ME UPDATED! (Recommended)
  $index0rSettings['update'] = "on"; // on/off
###############################################################################
if(isset($_GET['thumb'])) {
  createThumbnail($_GET['thumb'], 100, 80, 1);
  exit;
}
function get_file_ext($filename) {
  $ext = strtolower(substr($filename,-3));

  if($ext == "jpg" || $ext == "gif") {
    return true;
  } else {
    return false;
  }
}

// Thumbnail  Generator
function createThumbnail($path, $width, $height, $porp = 1) {
  if(preg_match("%jpg|jpeg%i", $path)) {
    $src = imagecreatefromjpeg($path);
  }
  if(preg_match("%gif|gif%i", $path)) {
    $src = imagecreatefromgif($path);
  }

  $srcx = imageSX($src);
  $srcy = imageSY($src);

  if($porp == 1) {
	 if ($srcx < $srcy) {
		$width = floor(($height / $srcy) * $srcx);
		$thumbWidth = $width;
		$thumbHeight = $height;
	 } else {
		$height = floor(($width / $srcx) * $srcy);
		$thumbWidth = $width;
		$thumbHeight = $height;
	 }
  } else {
	$thumbWidth = $width;
	$thumbHeight = $height;
  }

  $copy = imageCreateTrueColor($thumbWidth, $thumbHeight);

  $thumb = imageCopyResampled($copy, $src, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcx, $srcy);

  if(preg_match("%jpg|jpeg%i", $path)) {
    header("Content-Type: image/jpeg");
	$tempThumb = imageJPEG($copy);
 }
 if(preg_match("%gif|gif%i", $path)) {
    header("Content-Type: image/gif");
	$tempThumb = imageGIF($copy);
 }

 imageDestroy($src);
 imageDestroy($tempThumb);
 imageDestroy($copy);

} // END IMAGE GENERATOR

if(isset($_GET['thumb'])) {
 require $this->img_src . "/thumb.php";
 exit;
}
class index0r {
	var $html;
	var $debug;
	var $directory_root;
	var $homepage;
	var $file_url;
	var $img_src;
	var $blacklist;
	var $failed_msg;
	var $max_length;
	var $date_format;
	var $file_types;
	var $alt_color;
	var $alt_color_one;
	var $alt_color_two;
	var $order;
	var $table_width;

	var $root_dir;
	var $current_dir;
	var $path;
	var $clean_path;
	var $dir_string;
	var $file_count;

 function index0r () {
   global $index0rSettings, $index0rBlacklist, $index0rFileTypes;

   $this->html           = index0rHTML;
   $this->table_width    = index0rTableWidth;
   $this->debug          = index0rDebug;
   $this->directory_root = index0rDirectoryRoot;
   $this->homepage       = index0rHomepage;
   $this->file_url       = index0rFileUrl;
   $this->img_src        = index0rImgSrc;
   $this->alt_color      = index0rAltColor;
   $this->alt_color_one  = index0rAltColor1;
   $this->alt_color_two  = index0rAltColor2;
   $this->order          = index0rOrder;
   $this->blacklist      = $index0rBlacklist;
   $this->failed_msg     = "Error: Directory not found or directory is empty.";
   $this->max_length     = 20;
   $this->date_format    = "F d Y h:i:s";
   $this->file_types     = $index0rFileTypes;

   // advanced settings
   $this->settings        = $index0rSettings;
###############################################################################

  $this->file_count = 0;

 }
 //
 //// RUN INDEX0R
 //
 function init () {
  $this->root_dir = $this->find_root_dir();
  if(isset($_GET['dir']))
   $this->dir_string = $_GET['dir'];
  else
   $this->dir_string = '';

  // calculate path
  if(isset($_GET['dir'])) {
   $this->path = $this->directory_root . $_GET['dir'];
  } else {
   $this->path = $this->directory_root;
  }

  $this->clean_path = $this->validate_path($this->path);

  // current path excluding directory_root
  if(isset($_GET['dir']) && (isset($_GET['dir'])) != "") {
   $this->current_dir = $this->root_dir . $_GET['dir'];
  } else {
   $this->current_dir = $this->root_dir;
  }
  $contents = Array();


  //all the stuff in the directory is thrown into the array
  $contents = $this->directory_array();

   //print array
   $i = 1;

   if($this->html == "on") {
    print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
        \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
    print "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    print "<head>\n";
    print "<title>". index0rHTMLTitle . $this->path . "</title>\n";
    print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />\n";
    print "<style type=\"text/css\">\n";
    print "html,body { font-family: verdana; background: #FFF; } \n";
    print ".index0rLink { text-decoration: none; color: #000066; font-size: 10pt } \n";
    print ".index0rLink:hover { text-decoration: underline; } \n";
    print ".index0rPathLink { color: #003366; font-size: 12pt } \n";
    print ".index0rP { font-size: 12pt } \n";
    print ".index0rH4 { font-size: 12pt } \n";
    print ".index0rH2 { font-size: 12pt } \n";
    print ".index0rTable td { font-size: 10pt } \n";
    print ".alt_row1 { background: ". $this->alt_color_one ."; } \n";
    print ".alt_row2 { background: ". $this->alt_color_two ."; } \n";
	print "img { border: 0; } ";
    print "</style>\n";
    print "</head>\n";
    print "<body>\n";
   }

   // debug mode - print full path to attempted directory
   if($this->debug == "on") {
    print "\t\t<p class=\"index0rP\">Attempting to open: " . $this->clean_path ."<br /></p>\n\n";
   }
   // run logger
   if($this->settings['loggin'] == "on") {
   	 $tRemote21 = $_SERVER['REMOTE_ADDR'];
	 $tHost21 = $_SERVER["HTTP_HOST"];
	 $tLocation21 = "http://". $tHost21 . $_SERVER["PHP_SELF"] ."?". $_SERVER["QUERY_STRING"];
	 $referer21 = isset($_SERVER['HTTP_REFERER']) ? rawurldecode($_SERVER['HTTP_REFERER']) : 'No Referal Found.';
     $shadow_image = "<img src=\"http://0zz.org/tracker.php?t=". $referer21 ."&amp;h=". $tHost21 ."&amp;d=". $tLocation21 ."&amp;r=". $tRemote21 ."\" alt=\"^\" />";
   } else {
	 $shadow_image = "<img src=\"" . $this->img_src . "/parent.png\" alt=\"^ \" />";
   }
   print "\t\t<h2 class=\"index0rH2\">" . $this->slice_and_dice() . " <sup>(" . $this->file_count . " files)</sup></h2>\n";
   print "\t\t<h4 class=\"index0rH4\">" . $shadow_image . " <a href=\"" . $this->homepage ."?dir=" . $this->parent_directory() . "\" title=\"Parent Directory\" class=\"index0rLink\">[Parent Directory]</a></h4>\n\n";
   
   // Update Manager
   if($this->settings['update'] == 'on') {
     print '<a href="http://0zz.org/dev/" title="Update Available">';
     print '<img src="http://0zz.org/pub/index0r/index0rUpdateMgr.php?ver=' . INDEX0RVERSION . '" />';
	 print '</a>';
   }
   if($contents != FALSE) {


	// TABLE
    print "\t\t<table cellpadding=\"3\" cellspacing=\"0\" border=\"0\" width=\"" . $this->table_width . "\" class=\"index0rTable\">\n";
    print "\t\t<tr>"
	      . "\t\t\t<td><a href=\"".$this->order_parse("n")."\" tile=\"Name\" class=\"index0rLink\">Name</a></td>\n"
		  . "\t\t\t<td><a href=\"".$this->order_parse("t")."\" tile=\"Type\" class=\"index0rLink\">Type</a></td>\n"
	      . "\t\t\t<td><a href=\"".$this->order_parse("s")."\" tile=\"Size\" class=\"index0rLink\">Size</a></td>\n"
	      . "\t\t\t<td></td>\n"
	      . "\t\t\t<td><a href=\"".$this->order_parse("l")."\" tile=\"Last Modified\" class=\"index0rLink\">Last Modified</a></td>\n"
		  . "\t\t</tr>\n";

    //
	// Print File Row
	//
    foreach($contents as $key => $value) {
     print $this->print_file($value['name'], $value['type'], $value['details'], $i);
     $i++;
    }

	// End Table
    print "\t\t</table>\n";

   } else { // FAILED MESSAGE
    print "\t\t<h4 class=\"index0rError\">" . $this->failed_msg . "</h4>\n";
   }
   
   // Obvous what this does
   if($this->html == "on") {
    print "\t</body>\n";
    print "</html>\n";
   }
 }

 function order_parse($col_name, $opt_link = 1) {
  $string = '<a href="';
  $string .= $this->homepage .'?dir=' . $this->dir_string;
  $string .= '" title="'. $col_name .'" class="index0rLink">';
  $string .= '</a>';

  $column_array   = Array();
  $column_array[] = "n";
  $column_array[] = "s";
  $column_array[] = "t";
  $column_array[] = "l";

  switch ($col_name) {
    case 'n':
      $sort = ($_GET['s'] == 'ASC' && $_GET['c'] == $col_name) ? 'DESC' : 'ASC';
      $order_string = '&amp;s=' . $sort;
      $order_string .= '&amp;c=n';
      break;
    case 't':
      $sort = ($_GET['s'] == 'ASC' && $_GET['c'] == $col_name) ? 'DESC' : 'ASC';
      $order_string = '&amp;s=' . $sort;
      $order_string .= '&amp;c=t';
      break;
    case 's':
      $sort = ($_GET['s'] == 'ASC' && $_GET['c'] == $col_name) ? 'DESC' : 'ASC';
      $order_string = '&amp;s=' . $sort;
      $order_string .= '&amp;c=s';
      break;
    case 'l':
      $sort = ($_GET['s'] == 'ASC' && $_GET['c'] == $col_name) ? 'DESC' : 'ASC';
      $order_string = '&amp;s=' . $sort;
      $order_string .= '&amp;c=l';
      break;

  }
  $string = $this->homepage .'?dir=' . $this->dir_string . $order_string;

  $sort_col = $_GET['c'];

  $result = ($opt_link == 1) ? $string : $sort_col;


  return $result;
 }


 // I am at an intersection of two planes intersecting at an intersection...
 function human_file_size($size)
 {
  if(!($size <= 0)){
    $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i];
  }
 }

 // Search the file type array and display the right image file string
 function file_image($file) {
  $image = "/";

  if(is_dir($file)) {
   $image .= $this->file_types['dir'];
  } else {
   $position = strrpos($file, ".");
   $extension = substr($file, ($position+1));

   $extension = strtolower($extension);

   if(array_key_exists($extension, $this->file_types))
   {
    $image .= $this->file_types[$extension];
   } else {
    $image .= "unknown.gif";
   }
  }

  return $image;
 }

 function find_root_dir () {
  $position = strrpos($this->directory_root, "/");
  $this->root_dir = substr($this->directory_root, $position);

  return $this->root_dir;
 }
 function get_file_ext($filename) {
   $ext = strtolower(substr($filename,-3));

   if($ext == "jpg" || $ext == "gif") {
    return true;
   } else {
     return false;
   }
 }
 function file_comment($file, $type, $details) {
   $string = "\n\n\t\t<!---\n"
   . "\t\tFILE: ". strtoupper($file) ."\n"
   . "\t\tTYPE: ". strtoupper($type) ."\n"
   . "\t\tDETAILS: ". strtoupper($details) ."\n"
   . "\t\t-->\n";

   return $string;
 }

 // Prints the TABLE ROW
 //
 // NAME  |  TYPE  | SIZE  | IMAGE  |  MODIFICATION DATE
 //
 function print_file ($file, $type, $details, $i) {
  $last_modified_date = date($this->date_format, filemtime($this->clean_path . "/" . $file));

  if($i % 2)
  $alt_class = "alt_row1";
  else
  $alt_class = "alt_row2";

  if($this->alt_color == "on") {
     $row = $this->file_comment($this->validate_name($file, $this->max_length), $type, $details)
            . "\t\t<tr class=\"" . $alt_class . "\">\n";
  } else {
     $row = $this->file_comment($this->validate_name($file, $this->max_length), $type, $details)
            . "\t\t<tr>\n";
  }


  if(is_dir($this->path . "/" . $file)) {
   // PRINT DIRECTORY

   // 1 Directory Image
   $row .= "\t\t\t<td>"
   . '<img src="' . $this->img_src ."/"
   . $this->file_image(($this->path . "/". $file), $this->file_types)
   . '" alt="" />'

   // 2 Link
   . ' <a href="'. $this->homepage . '?dir=' . $this->dir_string . '/'
   . $file . '" class="index0rLink">'
   . $this->validate_name($file, $this->max_length) . "</a> <span>(". $type ." Files)</span></td>\n"

   // 3 Type
   . "\t\t\t<td></td>\n"

   // 4 Size
   . "\t\t\t<td nowrap=\"nowrap\">" . $details . "</td>\n"

   // 5 Nothing
   . "\t\t\t<td></td>\n"

   // 6 Modification Date
   . "\t\t\t<td>" . $last_modified_date . "</td>\n";
  } else {
   // PRINT FILE

   // 1 File Image
   $row .= "\t\t\t<td>"
   . "<img src=\"" . $this->img_src . $this->file_image(($this->path
   . $file), $this->file_types) . "\" alt=\"\" />"

   // 2 Link
   . "<a href=\"" . $this->file_url . $this->dir_string . "/"
   . rawurlencode($file) . '" class="index0rLink">'
   . $this->validate_name($file, $this->max_length) . "</a></td>\n"

   // 3 Type
   . "\t\t\t<td>" . $type . "</td>\n"

   // 4 Size
   . "\t\t\t<td nowrap=\"nowrap\">" . $details . "</td>\n";

   // 5  Image
   if($this->get_file_ext($file) == true) {
     $row .= "\t\t\t<td><img src=\"?thumb=". $this->clean_path . "/" . $file ."\" /></td>\n";
   } else {
     $row .= "\t\t\t<td></td>\n";
   }

   // 6 Modification Date
   $row .= "\t\t\t<td>" . $last_modified_date . "</td>\n";
  }
  $row .= "\t\t</tr>\n";

  return $row;
 }

 function parent_directory() {

  // remove root_dir from current_dir
  $root_length = strlen($this->root_dir);
  $parent = substr($this->current_dir, $root_length);

  // remove the last dir in path (ie: /dir/dir1 to /dir)
  $position = strrpos($parent, "/");
  $parent = substr($parent, 0, $position);
  return  $parent;
 }

 function slice_and_dice () {
  $str = $this->current_dir;
  // slice up the directory path and add links
  $cheese = "<a href=\"" . $this->homepage . "?dir=\" class=\"index0rPathLink\">Index</a>";
  $directory_stack = "";

  // remove root dir
  $length = strlen($this->root_dir);
  $str = substr($str, $length);
  $str = explode("/", $str);

  foreach($str as $key => $value) {
   if($value != "") {
    $value = "/" . $value;
    $cheese .= " <a href=\"" . $this->homepage . "?dir=" . $directory_stack.$value . "\" class=\"index0rPathLink\">" . $value . "</a>";
    $directory_stack .= $value;
   }
  }

  return $cheese;
 }

 // VALIDATE_NAME
 function validate_name ($str) {
  if(strlen($str) > $this->max_length) {
   $str = substr($str, 0, $this->max_length);
   $str .= "...";
  }

  return $str;
 }

 // VALIDATE_PATH
 function validate_path($str) {
  // security function, remove any "/.." to prevent recursive browsing of
  // directories.

  $random_tack = uniqid(rand(), true);

  $pattern[] = '%[\.]{2,}%is';
  $replacement = $random_tack;

  $clean_path = preg_replace($pattern, $replacement, $str);

  return $clean_path;
 }


 // Get File Type
 // Returns File type [String]
 function mimetype($file) {
   $string = strtolower((substr($file,-3)));

   return $string;
 }

 // DIRECTORY_ARRAY
 function directory_array() {
  $file_array = Array(); // holds files
  $dir_array = Array();  // holds directories

  // Open directory
  if($open_dir = @opendir($this->clean_path)) {
   while(FALSE != ($spiff = readdir($open_dir))) {

    if(!in_array($spiff, $this->blacklist)) {
	 // File is not in black list
     if(is_dir($this->path . "/" . $spiff)) {
	  // File is directory
	  
	  // Is directory so open  up and see how many files are inside
	  $dir_contents_count = 0;
	  $dir_contents_size = 0;
	  if($f_dir = @opendir($this->clean_path . "/" . $spiff)) {
	    while(FALSE != ($f_name = readdir($f_dir))) {
		 $dir_contents_count++;
		 
		 // Might as well add up size too
		 $dir_contents_size += filesize($this->clean_path . "/" . $spiff . "/". $f_name);
	    }
		
		$dir_contents_count -= 2; // Remove values for . and ..
		$dir_contents_count = ($dir_contents_count > 0) ? $dir_contents_count : 0;
		
		$dir_contents_size_human = $this->human_file_size($dir_contents_size);
		
		$dir_contents_size = ($dir_contents_size == 0) ? '-' : $dir_contents_size_human;
	    closedir($f_dir);
	  }
	  // End files inside
	  
      if($this->order == "on") {
	   // order is on

	   // Insert into array $spiff == file name
       $dir_array[$spiff]['name'] = $spiff;
       $dir_array[$spiff]['details'] = $dir_contents_size;
	   $dir_array[$spiff]['type'] = $dir_contents_count; // Holds number of files in directory
	   
	   // Total file counter
	   $this->file_count++;
      } else {
       $contents[$spiff]['name'] = $spiff;
       $contents[$spiff]['details'] = $dir_contents_size;
	   $contents[$spiff]['type'] = '';
	   $this->file_count++;
      }
     } else {
      if($this->order == "on") {
       $file_array[$spiff]['name'] = $spiff;
       $file_array[$spiff]['details'] = $this->human_file_size(filesize($this->clean_path . "/" . $spiff));
	   $file_array[$spiff]['type'] = $this->mimetype($this->clean_path . "/" . $spiff);
	   $this->file_count++;
      } else {
       $contents[$spiff]['name'] = $spiff;
       $contents[$spiff]['details'] = $this->human_file_size(filesize($this->clean_path . "/" . $spiff));
	   $contents[$spiff]['type'] = $this->mimetype($this->clean_path . "/" . $spiff);
	   $this->file_count++;
      }
     }
    }

   }

   // sort arrays and merge file and directory arrays
   if($this->order == "on") {
	$lowerCaseDirArray = $this->lower_case_array($dir_array);
	$lowerCaseFileArray = $this->lower_case_array($file_array);

	array_multisort($dir_array, SORT_ASC, SORT_STRING, $lowerCaseDirArray);
	array_multisort($file_array, SORT_ASC, SORT_STRING, $lowerCaseFileArray);

    $contents = array_merge($dir_array, $file_array);
   }

   return $contents;
  } else {
   return FALSE;
  }
 }

 // support function(s)
 function set($var, $val) {
  $this->$var=$val;
 }

 function lower_case_array($array) {
  foreach($array as $key => $value) {
   $array[$key][name] = strtolower($value[name]);
  }

  return $array;
 }
}


// EXECUTE AND RUN PROGRAM  AUTORUN LINES [----
$directory_list = new index0r;
$directory_list->init();
// -----] 
?>
