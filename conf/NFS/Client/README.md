##Create the Mount Points and Mount Remote Shares on the Client Server

Now that your host server is configured and making its directory shares available, we need to prep our client.
We create http service application mount point directory.
sudo mkdir -p /var/www/html/sudoku
sudo showmount –e serverIp
make sure Sudoku directory of server has existed. Mount /Sudoku to your http service directory:
sudo mount –t nfs servername(Public IP):/sudoku /srv/nfs4/Sudoku
df –h

Filesystem           Size  Used Avail Use% Mounted on
udev                 492M   12K  492M   1% /dev
tmpfs                100M  344K   99M   1% /run
/dev/xvda1            30G  1.7G   27G   6% /
none                 4.0K     0  4.0K   0% /sys/fs/cgroup
none                 5.0M     0  5.0M   0% /run/lock
none                 497M     0  497M   0% /run/shm
none                 100M     0  100M   0% /run/user
52.25.162.1:/sudoku  7.8G  1.5G  6.0G  20% /var/www/html/sudoku
If you want to see all of the NFS shares that you have mounted, you can type:
mount –t nfs

If you want to this setting still auto-effective when machine reboot, you must set /etc/fstab file:
sudo vi /etc/fstab
servername(Public IP):/sudoku /srv/nfs4/suduku  nfs rsize=8192,wsize=8192,timeo=14,intr 0 0
##Test NFS Access in Client

You can test the access to your shares by writing something to your shares. You can write a test file to one of your shares like this:
sudo touch /var/www/html/sudoku/test_sudo
ls -lrt /var/www/html/sudoku/test_sudo
-rw-r--r-- 1 root root 0 Apr 26 06:57 /var/www/html/sudoku/test_sudo

##Unmount an NFS Remote Share
If you no longer want the remote directory to be mounted on your system, you can unmount it easily by moving out of the share's directory structure and unmounting, like this:
umount /var/www/html/Sudoku
df -h
