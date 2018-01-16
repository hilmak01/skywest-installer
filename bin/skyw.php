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

$index = 1;
foreach ($packages as $name => $package) {
	$names[$index]  = $name;
	$clones[$index] = $repo = $package[$protocol];
	echo "\n\t[$index]  $name - $repo";
	$index++;	
}

print "\n\nWhat package would you like to clone?\n";
print "(Type number in [n] to select; type 0 or leave blank to abort):\n";

print "\n\t>>> ";
$n  = (int)trim(fgets($handle));
print "\n";

$count = count($packages);

switch ($n){
	case 0:
		exit("You've selected to stop this operation. Exiting...\n\r");
		break;

	case ($n <= $count):
		echo "You've selected the following package:\n\n";
		echo "   $names[$n]: ".($repo = $clones[$n])."\n\n";
		break;

	case ($n > $count):
		exit("That package '[$n]' doesn't exist!\n");
		break;
	
	default:
		echo "Okay, nothing will be installed. ABORTING...!\n";
	    exit;
		break;
}
print "Where would you like to clone this repository to (relative to this folder)?: \n";
print "\tType './' for this directory or '../' for parent of this directory to startn\n";
print "\tThen type directory name you want to create. e.g. '../jumanji', or './jumanji'\n";

print "\n\t>>> ";
$dir = trim(fgets($handle));
print "\n";

if(file_exists($dir)) exit("This directory already exists! Please use a different name");

print "\nWhat branch are you going to clone?: \n";
print "(Leave blank for the default branch, usually master, or type the name of the branch, e.g. '1.0-x')\n";

print "\n\t>>> ";
$branch = trim(fgets($handle));
print "\n";

if(!empty($branch)) $branch = "-b $branch ";

fclose($handle);

shell_exec("git clone $branch$repo $dir && cd $dir && composer update");
echo "\n\nThank you, finishing...\n\n\r";
