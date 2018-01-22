# Overview
This package, 'skywest-installer' is created to easy the process of creating a new skywestairlines repository from the command-line.

## Requirements
To use this command you need to have composer installed on your machine. Instructions are here: https://getcomposer.org/download/

Also, although not required, since you are dealing with git, it is best to use Git-Bash for these commands, especially if you are running Windows. To download, head over to https://git-scm.com/

## Installation
At the command prompt type (or just copy and paste the line):

        composer global require skywest/installer dev-master --prefer-source
  
This will install the "skw" command on the composer global space. When prompted follow the instructions to complete.

## Usage
Just type the following command to start the cloning process:
       
       skyw
       
If you wish to specify a directory to speed things up just replace *\<dir\>* below with the name of the directory you wish to clone your new repository into.
        
        skyw <dir>

By default, this command will first check if there is a newer version of this install and automatically install it. To skip this processs, you can issue a skip flag to the command to skip updating

        skyw <dir> --skip
Or, in short,

        skyw <dir> -s

Other flags you can use are:

       --help, or -h            show this page, or a help section for this 'skw' command
       --default or -d          run 'skyw' command faster, using all the defaults at each prompt

## Authors
* Hilkiah Makemo                HilkiahMakemo@github.com

## License
Copyright (c) 2018, <copyright holder>
Property of SkyWest Airlines.
