<?php

namespace SKYW;

print "\n=============================================================================\n";
print "\n\t";
print "\t\tSKYWEST INSTALLER, v1.0";
print "\n\t";
print "\n=============================================================================\n";

if(isset($argv[1]) && ($argv[1] == '--help' || $argv[1] == '-h')){
  print "open this file to view the README content:\n\n\t".realpath(__DIR__.'/../README.md')."\n\n";
	exit();
}
if(!isset($argv[1]) || ($argv[1] != '--skip' && $argv[1] != '-s')){

	print "\nChecking for updated version of this installer?\n";
	print "--------------------------------------------------------------------------------\n";
	shell_exec("composer install --prefer-source");
	print "\nUpdate check completed!...\n";
	print "--------------------------------------------------------------------------------\n";

}

print "\n";

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

print "\n\tProtocol: >>> ";
$protocol  = (int)trim(fgets($handle)) == 0? 'https': 'ssh';
print "\n";

$repo = null;
$names = array();
$clones = array();
$mkdir = false;

$index = 1;
print "The following repositories (installed by this tool) were found in the system!\n";
foreach ($packages as $name => $package) {
	$names[$index]  = $name;
	$clones[$index] = $pack = $package[$protocol];
	echo "\n\t[$index]  $name - $pack";
	$index++;
}

print "\n\nWhat package would you like to clone?\n";
print "(Type number in [n] to select; type 0 or leave blank to abort):\n";

print "\n\tRepository: >>> ";
$n  = (int)trim(fgets($handle));
print "\n";

$count = count($packages);

switch ($n){
	case 0:
		exit("You've selected to abort this operation. Aborting!...\n\r");
		break;

	case ($n <= $count):
		echo "You've selected the following package:\n\n";
		echo "\tURL: $names[$n]\n\tGIT: ".($repo = $clones[$n])."\n\n";
		break;

	case ($n > $count):
		exit("That package '[$n]' doesn't exist! Aborting!...\n");
		break;

	default:
		echo "Okay, nothing will be installed. Aborting!...\n";
	    exit;
		break;
}
if(empty($repo)){
	exit("Sorry, you didn't select any repository! Aborting!...");
}
print "Where would you like to clone this repository to (relative to this folder)?: \n";
print "\tType './' for this directory or '../' for parent of this directory to startn\n";
print "\tThen type directory name you want to create. e.g. '../jumanji', or './jumanji'\n";
print "\tOr leave it blank to use the default name of the repository for installation'\n";

print "\n\tLocation: >>> ";
$dir = trim(fgets($handle));
print "\n";

if(empty($dir)){
	$parts = explode("/", $repo);
	$dir   = array_pop($parts);
	$dir   = './'.str_replace(".git", "", $dir);
}
else{
	$total = count(glob("$dir/*"));
	$exists = "";
	$notEmpty = " and, it is not empty!";

	if(file_exists($dir) || is_dir($dir))
		$exists .= "This directory already exists!";

	if($total > 0)
		$exists .= $notEmpty;

	if($exists != "" && strpos($exists, $notEmpty) !== false){
		rmdir($dir);
		exit("$exists\nPlease you a different directory name!\n\Aborting...\r");
	}
}
if(!is_dir($dir)) mkdir($dir, 0755, true);
$mkdir = true;
print "Your repository will be cloned in:\n\n";
print "\t".realpath($dir)."\n\n";

print "Which branch are you going to clone into $dir?: \n";
print "\tType the name of the branch, (e.g. '3.6.4, or 1.0-x')\n";
print "\tOr, leave blank for the default branch, (usually master)\n";

print "\n\tBranch: >>> ";
$branch = ($B = trim(fgets($handle))) != ''? $B: 'default';
print "\n";

print "Your $branch branch will be created in '$dir'\nContinue? ['Y' or 'N']: \n";

print "\n\tConfirm: >>> ";;
$confirm = trim(fgets($handle));
print "\n";

if(strtoupper($confirm) != 'Y'){
	if($mkdir && realpath($dir.'/.git')){
		rmdir(realpath($dir.'/.git'));
	}
	if($mkdir && realpath($dir)){
		rmdir(realpath($dir));
	}
	exit("Aborting...\n\r");
}
$b = ($branch != 'default')? "-b $branch ": '';

fclose($handle);

try {
	shell_exec("git clone $b$repo $dir && cd $dir && composer update");
	echo "\n\nThank you, Finishing...\nSuccess!\n\n\r";
}
catch (\Exception $e) {
	echo $e->getMessage();
	exit();
}
