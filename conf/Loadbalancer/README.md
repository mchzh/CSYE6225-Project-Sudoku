##This folder contains information regarding 

1. How to setup an EC2 instance as a  load balancer

2. How to setup a high availability load balancer

We use a shell script called vip_monitor.sh. A virtual IP monitor and takeover script (vip_monitor.sh).This script enables one EC2 instance to monitor another EC2 instance and take over a private "virtual" IP address on instance failure.When used with two
instances, the script enables an HA (High availability) scenario where instances monitor each other and take over a shared virtual IP address if the other instance fails. You can find the shell script in "src" folder
