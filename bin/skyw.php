<?php

namespace SKYW;

$packages = [
	"www.skywest.com"  => [
		'https' => "https://github.com/skywestairlines/www.skywest.com.git",
		'ssh'  => "git@github.com:skywestairlines/www.skywest.com.git"
	],
	"inc.skywest.com"  => [
		'https' => "https://github.com/skywestairlines/inc.skywest.com.git",
		'ssh'  => "git@github.com:skywestairlines/inc.skywest.com.git"
	],
	"blog.skywest.com" => [
		'https' => "https://github.com/skywestairlines/blog.skywest.com.git",
		'ssh'  => "git@github.com:skywestairlines/blog.skywest.com.git"
	],
	"www.miniindy.org" => [
		'https' => "https://github.com/skywestairlines/www.miniindy.org.git",
		'ssh'  => "git@github.com:skywestairlines/www.miniindy.org.git"
	]
];


/***************************************************************************/
$handle = fopen ("php://stdin","r");
print "\nAre you going to be using 'https' or 'ssh' for this?";
print "\n(Leave blank or enter 0 for https, or enter 1 for ssh):";
print "\n\n\t>>> ";
$protocol  = (int)trim(fgets($handle)) == 0? 'https': 'ssh';

$names = array();
$clones = array();

$index = 0;
foreach ($packages as $name => $package) {
	$names[$index]  = $name;
	$clones[$index] = $clone = $package[$protocol];
	echo "\t[$index]  $name - $clone\n";
	$index++;	
}

print "\nWhat package would you like to clone?\n\n";
print "\nType number in [n] to select or leave blank to abort:";
print "\n\n\t>>> ";
$n  = (int)trim(fgets($handle));
$count = count($packages);

switch ($n){
	case ($n < $count):
		echo "\nYou've selected the following package:\n\n ";
		echo "   $names[$n]: ".($clone = $clones[$n])."\n\n";
		break;

	case ($n >= $count):
		exit("That package '[$n]' doesn't exist!\n");
		break;
	
	default:
		echo "Okay, nothing will be installed. ABORTING...!\n";
	    exit;
		break;
}
print "Where would you like to clone this repository to (relative to this folder)?: \n";
print "\tType './' for this directory or '../' for parent of this directory to startn\n";
print "\tThen type directory name you want to create. e.g. '../jumanji', or './jumanji'";
print "\n\n\t>>> ";

$dir   = trim(fgets($handle));
fclose($handle);
if(!is_dir($dir)) mkdir($dir, 0775, true);

shell_exec("git clone $clone $dir && cd $dir && composer update");
echo "\n\nThank you, continuing...\n\n\r";
