# Overview
This package, 'skywest-installer' is created to easy the process of creating a new skywestairlines repository from the command-line.

## Requirements
To use this command you need to have composer installed on your machine. Instructions are here: https://getcomposer.org/download/

## Installation
At the command prompt type (or just copy and paste the line):

        composer global require skywest/installer dev-master --prefer-source
  
This will install the "skw" command on the composer global space. When prompted follow the instructions to complete.

## Usage
Just type the following command to start the cloning process:
       
       skw

Current options for this command are '--update' or '-u' which lets composer check if there is a newer version of this installer available.
To use this option do

       skyw --update
