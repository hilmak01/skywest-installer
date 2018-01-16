<?php

namespace SKYW;

print "\n=============================================================================\n";
print "\n\t";
print "\t\tSKYWEST INSTALLER, v1.0";
print "\n\t";
print "\n=============================================================================\n";
print "\nChecking for updated version of this installer?\n";
shell_exec("composer install");

print "\nUpdate check completed!...\n";
print "--------------------------------------------------------------------------------\n\n";

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
print "Are you going to be using 'https' or 'ssh' for this?\n";
print "(Leave blank or enter 0 for https, or enter 1 for ssh):\n";

print "\n\t>>> ";
$protocol  = (int)trim(fgets($handle)) == 0? 'https': 'ssh';
print "\n";

$names = array();
$clones = array();

$index = 1;
print "The following repositories (installed by this tool) were found in the system!\n";
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

$total = count(glob("$dir/*"));

$exists = ""; 
$notEmpty = " and, it is not empty!";
if(file_exists($dir) || is_dir($dir)) $exists .= "This directory already exists!";
if($total > 0) $exists .= $notEmpty;
if($exists != "" && strpos($exists, $notEmpty) !== false)
	exit("$exists\nPlease you a different directory name!\n\r");

print "Which branch are you going to clone into $dir?: \n";
print "(Leave blank for the default branch, usually master, or type the name of the branch, e.g. '1.0-x')\n";

print "\n\t>>> ";
$branch = trim(fgets($handle)) ?? 'default';
print "\n";
 
print "Your $branch branch will be created in '$dir. Continue? ['Y' or 'N']: \n";

print "\n\t>>> ";
$confirm = trim(fgets($handle));
print "\n";

if(strtoupper($confirm) != 'Y') exit("Aborting...\n\r");
if($branch != 'default') $branch = "-b $branch ";

fclose($handle);

// if(!is_dir($dir)) mkdir($dir, 0775, true); 
// $dir = realpath($dir);

shell_exec("git clone $branch$repo $dir && cd $dir && composer update");
echo "\n\nThank you, finishing...\n\n\r";
