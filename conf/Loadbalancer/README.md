##This folder contains information regarding 

1. How to setup a single load balancer

2. How to setup a high availability load balancer

3. The configuration file for load balancer is given

4. We use a shell script called vip_monitor.sh. A virtual IP monitor and takeover script (vip_monitor.sh).This script enables on 
EC2 instance to monitor another EC2 instance and take over a private "virtual" IP address on instance failure.When used with two
instances, the script enables an HA (High availability) scenario where instances monitor each other and take over a shared virtual IP address if the other instance fails. You can find the shell script in "src" folder
