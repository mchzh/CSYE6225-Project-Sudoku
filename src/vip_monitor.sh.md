```

#!/bin/sh
# This script will monitor another HA node and take over a Virtual IP (VIP)
# if communication with the other node fails

# High Availability IP variables
# Other node's IP to ping and VIP to swap if other node goes down
HA_Node_IP=                  #Enter your private IP here
VIP=                         #Enter the Virtual IP

# Specify the EC2 region that this will be running in
REGION=                      #Enter the region where you instances are deployed

# Run aws-apitools-common.sh to set up default environment variables and to
# leverage AWS security credentials provided by EC2 roles
. /etc/profile.d/aws-apitools-common.sh

# Determine the instance and ENI IDs so we can reassign the VIP to the
# correct ENI. Requires EC2 describe-instances and assign-private-ip-address
# permissions. The following example EC2 roles policy will authorize these
# commands:
# {
# "Statement": [
# {
# "Action": [
# "ec2:AssignPrivateIpAddresses",
# "ec2:DescribeInstances"
# ],
# "Effect": "Allow",
# "Resource": "*"
# }
# ]
# }

Instance_ID=`/usr/bin/curl --silent http://169.254.169.254/latest/meta-data/instance-id`
ENI_ID=`/opt/aws/bin/ec2-describe-instances $Instance_ID --region $REGION | grep eni -m 1 | awk '{print $2;}'`

echo `date` "-- Starting HA monitor"
while [ . ]; do
 pingresult=`ping -c 3 -W 1 $HA_Node_IP | grep time= | wc -l`
 if [ "$pingresult" == "0" ]; then
 echo `date` "-- HA heartbeat failed, taking over VIP"
 /opt/aws/bin/ec2-assign-private-ip-addresses -n $ENI_ID --secondary-private-ip-address $VIP --allow-reassignment --region $REGION
 pingresult=`ping -c 1 -W 1 $VIP | grep time= | wc -l`
 if [ "$pingresult" == "0" ]; then
 echo `date` "-- Restarting network"
 /sbin/service network restart > /dev/null 2>&1
 fi
 sleep 60
 fi
 sleep 2
done
```
