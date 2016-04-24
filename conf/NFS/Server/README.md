How To Set Up an NFS Mount on Ubuntu instance of AWS

Introduction
NFS, or Network File System, is a distributed filesystem protocol that allows you to mount remote directories on your server. This allows you to leverage storage space in a different location and to write to the same space from multiple servers easily. NFS works well for directories that will have to be accessed regularly.
In this guide, we'll cover how to configure NFS mounts on an Ubuntu instance server.
Download and Install the Components
Before we can begin, we need to install the necessary components on both our host and client servers.
On the host server, we need to install the nfs-kernel-server package, which will allow us to share our directories. Since this is the first operation that we're performing with apt in this session, we'll refresh our local package index before the installation:
sudo apt-get update
sudo apt-get install nfs-kernel-server
Once these packages are installed, you can switch over to the client computer.
On the client computer, we're going to have to install a package called nfs-common, which provides NFS functionality without having to include the server components. Again, we will refresh the local package index prior to installation to ensure that we have up-to-date information:
sudo apt-get update
sudo apt-get install nfs-common

Create the Share Directory on the Host Server
We create NFS root directory-/srv/nfs4 and share /mnt/Sudoku
sudo mkdir -p /srv/nfs4/sudoku
sudo mkdir -p /mnt/sudoku
make sure Sudoku direcotory has rw priviledge. Mount /mnt/Sudoku to NFS sharing:
sudo mount --bind /mnt/sudoku /srv/nfs4/Sudoku
If you want to this setting still auto-effective when machine reboot, you must set /etc/fstab file:
sudo vi /etc/fstab
/mnt/sudoku /srv/nfs4/suduku  none   bind   0   0

sudo service nfs-kernel-server restart
sudo showmount -e
Configure the NFS Exports on the Host Server
Now that we have our directories created and assigned, we can dive into the NFS configuration file to set up the sharing of these resources.
Add the permitted-mount directory and machine to exports
sudo vi /etc/exports
/srv/nfs4/ *(rw,sync,fsid=0,no_subtree_check)
/srv/nfs4/sudoku *(rw,sync,no_subtree_check,nohide) #note the nohide option which is applied to mounted directories on the file systems
Next, you should create the NFS table that holds the exports of your shares by typing:
sudo exports –ra
sudo service nfs-kernel-server restart
Test NFS Access in Host Server

Our design is that to create NFS root directory bind another mount directory, so we need copy different file into this two directory separately and to check whether another directory will update this copy file. Also you can test the access to your shares by writing something to your shares. 
sudo cp /home/ubuntu/load.sh /mnt/sudoku/.
ls –lrt /mnt/sudoku/.
ls –lrt /srv/nfs4/sudoku/.
cd
sudo cp /home/ubuntu/1.log /srv/nfs4/sudoku/.
ls -lrt /srv/nfs4/sudoku
ls -lrt /mnt/sudoku
