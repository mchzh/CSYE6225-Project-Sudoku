#  CSYE6225-Project-Sudoku
Cloud Coumputing Project for the Algorithm Forum

In this project, it include source, configure and documentation file etc.

-----
##1. how to get github resource 

Install git and gcc for viewing and compiling the code. I assume you have Debian or Ubuntu:

sudo apt-get install git gcc

setup your git repo:

git config --global user.name "yourusername"

git config --global user.email "youremail"

git clone [SudokuGit](https://github.com/mchzh/CSYE6225-Project-Sudoku.git)

cd to CSYE6225-Project-Sudoku

when you chang any code you want to upload your changes:

git add xx

git commit -m 'change reason interpret'

After commit, you must also push your change to remote repository:

git remote add origin [SudokuGit](https://github.com/mchzh/CSYE6225-Project-Sudoku.git)

git push origin master
[SudokuGit](https://github.com/mchzh/CSYE6225-Project-Sudoku.git)

-----
##2. Directory interpret
   
   /bin : Excute binary code of project
   
   /src : Source program code of project, and include php, shell script etc.
   
   /conf : Configure file of project
   
   /log : every service log file including nginx, apache2, and HA etc.
   
   /document : all description documentation of this project

-----
##3. AWS VM description
   In this project, we use two type VM : one is "Amazon Linux AMI 2016.03.0 (HVM), SSD Volume Type - ami-c229c0a2"(for LB) and another is "Ubuntu Server 14.04 LTS (HVM), SSD Volume Type - ami-9abea4fb"(for apache and file server).
   
   (1) LB Instance

   (2) Application Instance
   
       Instance type : t2.micro
       
       Sytem info : Linux version 3.13.0-83-generic (buildd@lgw01-55) (gcc version 4.8.2 (Ubuntu 4..2-19ubuntu1) ) #127-Ubuntu SMP Fri Mar 11 00:25:37 UTC 2016 (uname -a)
       
       Version : Ubuntu 14.04.4 LTS (head -n 1 /etc/issue )
       
       Cpu cores       : 1 (cat /proc/cpuinfo | grep -i cpu)
       
       Mem:           992  (free -m)
       
       /dev/xvda1      7.8G (df -hl)

-----
##4. Set loadbalance high availibility

   [LB HA install and setting](https://aws.amazon.com/articles/2127188135977316)

   More details go to /conf/Loadbalancer/nginx.conf for Linux users.md

-----
##5. Install and configure application
 
-----  
##6. Install and configure file server and client

   More details go to /conf/NFS/Server/README.md and /conf/NFS/Client/README.md


