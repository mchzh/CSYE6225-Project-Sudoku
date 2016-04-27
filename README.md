#  CSYE6225-Project-Sudoku

The project includes source, configuration and documentation files.

-----
##1. How to extract github resource 

Install git and gcc for viewing and compiling the code. Follow the steps mentioned below (I assume you have Debian or Ubuntu):

```sudo apt-get install git gcc```

setup your git repo:

```git config --global user.name "yourusername"```

```git config --global user.email "youremail"```

```git clone https://github.com/mchzh/CSYE6225-Project-Sudoku.git```

```cd CSYE6225-Project-Sudoku```

When you want to upload any changes to your code:

```git add xx```

```git commit -m ```

After you commit your changes, you must push your edited file to a remote repository:

git remote add origin [SudokuGit](https://github.com/mchzh/CSYE6225-Project-Sudoku.git)

git push origin master [SudokuGit](https://github.com/mchzh/CSYE6225-Project-Sudoku.git)

-----
##2. Directory interpretation
   
   /bin : Binary code of project
   
   /src : Source code of project which includes php and shell script.
   
   /conf : Configuration files of the project
   
   /log :  Service log file 
   
   /document :  Description documents of the project
   
   /help :  technology solution, problem description and user guide

-----
##3. AWS VM description
   In this project, we use two types of Virtual machines : 
   
   "Amazon Linux AMI 2016.03.0 (HVM), SSD Volume Type-ami-c229c0a2"(for Load Balancer) 
   
   "Ubuntu Server 14.04 LTS (HVM), SSD Volume Type-ami-9abea4fb"(for apache web server and file server).
   
   
   (1) Load Balancer Instance
       
       Instance type : t2.micro
       
       system info: Amazon Linux AMI 2016.03.0 (HVM), SSD Volume Type - ami-c229c0a2
       
       Version: Amazon Linux AMI release 2016.03
       
       CPU cores:          1 (cat /proc/cpuinfo | grep -i cpu)
       
       Mem:                995 (free -m) 
       
       Total disk space    7.8G (df -hl)
        
   (2) Application and file server Instance
       
       Instance type : t2.micro
       
       Sytem info : Linux version 3.13.0-83-generic (buildd@lgw01-55) (gcc version 4.8.2 (Ubuntu 4..2-19ubuntu1) ) #127-Ubuntu SMP Fri Mar 11 00:25:37 UTC 2016 (uname -a)
       
       Version : Ubuntu 14.04.4 LTS (head -n 1 /etc/issue )
       
       Cpu cores              1 
       
       Mem:                   992
       
       Total disk space       7.8G

   (3) Except EC2, we use some component like VPC and IAM, Volume

-----
##4. Setting a High-availibility load balancer

   For details go to /conf/Loadbalancer/nginx.conf for Linux users.md
   
   reference :[Load Balancer Hight Availability configuration](https://aws.amazon.com/articles/2127188135977316)

   
-----
##5. Install and configure the application on backend servers
 
-----  
##6. Install and configure file server and client

   For details go to /conf/NFS/Server/README.md and /conf/NFS/Client/README.md
   [NFS Server](https://github.com/mchzh/CSYE6225-Project-Sudoku/blob/master/conf/NFS/Server/README.md)
   [NFS Client](https://github.com/mchzh/CSYE6225-Project-Sudoku/blob/master/conf/NFS/Client/README.md)


