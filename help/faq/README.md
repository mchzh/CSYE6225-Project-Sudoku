#During this project, we encounter some technology problem and finally solve it and list them.

   1.LB HA monitor backup display "Network unreachable" when shutdown the primary LB.

    Reason: The two LB not deploy the same VPC and IAM.

    Solution: It must create a new VPC and IAM to associate these two LB.

   2.After mount the NFS server share directory in client, it can read the file of file server but not update and add file.

    Reason: Although the file server set this share directory "rw" priviledge, but default require root_squash.

    Solution: In file server, open /etc/exports to edit this share direcotry and add no_root_squash option. Then sudo exportfs -a.
    
   3. Run nginx load balancer setup automatically when the instance is run
      
     open the file rc.local
   
      ```vi /etc/rc.local```

      add the line 
      
      /etc/init.d/nginx start
      
      This will start the nginx load balancer as you start your instance

