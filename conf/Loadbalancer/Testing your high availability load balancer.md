####Watch the vip_monitor.log file on secondary load balancer while you shutdown primary load balancer and observe the script take over the VIP.

#####Primary load balancer:
```
[root@ip-10-0-0-11 ~]# shutdown -r now 
[root@ip-10-0-0-11 ~]# 
Broadcast message from ec2-user@ip-10-0-0-11
 (/dev/pts/0) at 14:28 ...

The system is going down for reboot NOW!
```

#####Secondary load balancer:
```
[root@ip-10-0-0-12 ~]# tail -f /tmp//vip_monitor.log 
Mon Apr 23 14:28:18 UTC 2016 -- Starting HA monitor
Mon Apr 23 14:29:03 UTC 2016 -- HA heartbeat failed, taking over VIP      # "taking over VIP" denotes that the secondary load 
RETURN true                                                               #  balancer is assigned the Virtual IP 
Mon Apr 23 14:29:06 UTC 2016 -- Restarting network
```
