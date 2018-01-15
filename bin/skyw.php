<?php

namespace SKYW;

print "\nWhat package would you like to clone?\n\n";

$packages = [
	"www.skywest.com"  => "https://github.com/skywestairlines/www.skywest.com.git",
	"inc.skywest.com"  => "https://github.com/skywestairlines/inc.skywest.com.git",
	"blog.skywest.com" => "https://github.com/skywestairlines/blog.skywest.com.git",
	"www.miniindy.org" => "https://github.com/skywestairlines/www.miniindy.org.git"
];

$names = array();
$clones = array();

$index = 0;
foreach ($packages as $name => $package) {
	$names[$index]  = $name;
	$clones[$index] = $package;
	echo "     [$index]  ".$name.PHP_EOL;
	$index++;	
}

print "\nType number in [n] to select or leave blank to abort: \n\n>>>";

$handle = fopen ("php://stdin","r");
$line1  = fgets($handle);

switch ($n = trim($line1)){
	case ($n < count($packages)):
		echo "\nYou've selected the following package:\n\n ";
		echo "   $names[$n]: ".($clone = $clones[$n])."\n\n";
		break;

	case ($n <= count($packages)):
		exit("That package '[$n]' doesn't exist!\n");
		break;
	
	default:
		echo $n. "Okay, nothing will be installed. ABORTING...!\n";
	    exit;
		break;
}
print "Where would you like to clone this repository to?: \n";
print "   Type './' for this directory or '../' for parent of this directory\n";
print "   Or, type directory name to create one in this directory\n\n>>>";

$line2 = fgets($handle);
$dir   = $line2;
fclose($handle);

shell_exec("git clone $clone $dir && cd $dir && composer update");
echo "\n\nThank you, continuing...\n\n\r";