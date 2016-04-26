#####This document shows the set up a single load balancer and setup of a high-availability load balancer 


Elastic Load Balancing automatically distributes incoming application traffic across multiple Amazon EC2 instances in the cloud. It enables you to achieve greater levels of fault tolerance in your applications, seamlessly providing the required amount of load balancing capacity needed to distribute application traffic.

We will be using nginx as our load balancer. Nginx (pronounced "engine x") is a web server. It can act as a reverse proxy server for HTTP, HTTPS, SMTP, POP3, and IMAP protocols, as well as a load balancer and an HTTP cache.

#####SETTING A SINGLE LOAD BALANCER:

The procedure described below is for both linux and ubuntu instances:
	
STEP 1: sudo yum update   		#update your instance
        
        
STEP 2: sudo yum install nginx   	#install nginx
        
STEP 3: We have to configure nginx to act as a load balancer, to do this we need to access the nginx.conf file
        
cd /etc/nginx
      	
vi nginx.conf
        
	
To start using NGINX with a group of servers, first, you need to define the group with the upstream directive. The directive is placed in the http context.Servers in the group are configured using the server directive. For example, In the below description the following configuration defines a group named "backend" and consists of two server configurations.To pass requests to a server group, the name of the group is specified in the proxy_pass directive.Server running on NGINX passes all requests to the backend server group that you will be defining.
        
Inside the nginx.conf file under the "http" section add the following lines:
        
        
        upstream backend{
        server 172.31.xxx.xxx;  #insert the private ip address of your backend servers
        server 172.31.xxx.xxx;
        }
        
         location /{
            proxy_pass http://backend;
        }
        
  	
Save the nginx.conf file after you have finished editing it. You need to restart the service for the changes to take place

sudo service nginx restart
        

#####SETTING UP A HIGH-AVAILABILITY LOAD BALANCER:

If one of your application server is down, you have a back up server that has the same application running on it to take over. But what if the load balancer that is distributing the traffic across the backend servers fails? If the load balancer fails then none of your clients can access the application. The solution is to have two load balancers, one primary and the other is secondary (backup). 

IMPLEMENTATION:
We have a virtual IP that floats between the two load balancers. Initially the virtual IP is assigned to your primary load
balancer. A monitoring system is put in place that checks the health of the two load balancers. If the primary load balancer 
is unhealthy the monitoring system will recognize this and assigns the virtual IP to the secondary load balancer which takes 
charge of the incoming traffic.

To achieve the above architecture we require Elastic IP addresses and a shell script for monitoring (vip_monitor.sh):

An Elastic IP address is a static IP address designed for dynamic cloud computing. With an Elastic IP address, you can mask 
the failure of an instance or software by rapidly remapping the address to another instance in your account.An Elastic IP 
address is a public IP address, which is reachable from the Internet. 

STEP 1: Create an EC2 AWS Identity and Access Management (IAM) role that will authorize our EC2 instances to be able to take 
over the Virtual IP in the event that the other EC2 instance fails.Navigate to the IAM console in the AWS Management Console, click  Roles in the navigation pane, and click Create New Role.Give the new role a descriptive name (HA_Monitor in this example) and click Continue.Navigate to the "Inline Policy" section of the role that you just created and select "Custom Policy".Enter the following for the policy document:
					 
					 	
					 	{
						 "Statement": [
						 {
						 "Action": [
						 "ec2:AssignPrivateIpAddresses",
						 "ec2:DescribeInstances"
						 ],
						 "Effect": "Allow",
						 "Resource": "*"
						 }
						 ]
						}
      						

STEP 2: Launch two EC2 instance and configure them as a load balancers by following the first procedure. One of the instances
is your primary load balancer and the other one is secondary load balancer.
NOTE:Choose the IAM role as the one that you have created in STEP 1 when launching the EC2 instances

STEP 3: For the instance that you choose as a primay load balancer, right click the instance and select "Networking" and select "Manage private IP addresses".Select "Assign new IP" and click "Yes,Update". This new secondary private IP will act as the virtual IP that floats between the two load balancers. 

STEP 4: In "EC2 Dashboard" under "NETWORK & SECURITY" click "Elastic IPs".Click on "Allocate New Address" and choose your 
instances.By default an Elastic IP is allocated to the primary private IP of your primary load balancer, to assign an Elastic IP to the secondary private IP you click "ALlocate New Address" again and choose the primary load balancer.Repeat the above step for the secondary load balancer but only once since we did not assign any secondary private IP address
	
STEP 5: After step 4 access your instances and do the following:
	
Change to the root user

sudo -s 
	
Change to root directory

cd /root
	
download the vip_monitor.sh script, and make it executable with the following commands:

```wget http://media.amazonwebservices.com/articles/vip_monitor_files/vip_monitor.sh  #download vip_monitor.sh```
	
change the permission on the file

chmod a+x vip_monitor.sh
	
NOTE:vip_monitor.sh is a virtual IP monitor and takeover script.This script enables one Amazon EC2 instance to monitor 
another Amazon EC2 instance and take over a private "virtual" IP address on instance failure. When used with two instances, the script enables an HA (High-availability) scenario where instances monitor each other and take over a shared virtual IP address if the other instance fails.

Edit the following variables to match your settings for primary load balancer:
	
HA_Node_IP - This should point to secondary load balancer primary private IP address.
VIP - This should point to private virtual IP address that will float between the two load balancers.
REGION - This should point to region where your load balancers are running (example :us-west-2).
	
Now connect to secondary load balancer and issue the same commands as you did previously on primary load balancer. 
However, in this case, configure vip_monitor.sh with the following settings:
	
HA_Node_IP - This should point to primary load balancer primary private IP address.
VIP - This should point to private virtual IP address that will float between the two primary load balancer    
REGION - This should point to region where your load balancers are running (example :us-west-2).

After completing all the above steps, you can test your setup by shutting down the primary load balancer. Once you shutdown the primary load balancer, the virtual IP address is allocated to the secondary load balancer and all the traffic is redirected to the secondary load balancer. Kindly check the "Testing your high availability load balancer" for reference.

        
        
        

        
        
        
        
        
