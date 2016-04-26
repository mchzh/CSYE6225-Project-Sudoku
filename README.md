# CSYE6225-Project-Sudoku
Cloud Coumputing Project for the Algorithm Forum

In this project, it include source, configure and documentation file etc.


1. how to get github resource 

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

2. Directory interpret
   /bin : Excute binary code of project
   /src : Source program code of project, and include php, shell script etc.
   /conf : Configure file of project
   /log : every service log file including nginx, apache2, and HA etc.
3. 

(1) launch a VM (required size based not eh capacity model you have, it will be good if you submit it also in a separate file) (2) configure the VM with something (VNET, disk, etc). (3) on the development station (your Mac) do : 3.1, 3.2, 3.3….
(4) how to download into github to your repo. (git pull….) (5) install some components e.g. php, apache nginx etc. (6) how to start your app/service. more importantly how to make it start automatically with no user push anything (etc/init.d …)

