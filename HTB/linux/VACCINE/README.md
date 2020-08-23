# VACCINE
```
IP = 10.10.10.46
```

Enumeration
---------------------
+ Ran the initial and all vuln nmap scan.
+ Found FTP credentials in the previous OOPSIE box:
	[ftpuser:mc@F1l3ZilL4]
+ Found a file called `backup.zip`.
+ The zip file is password protected, used zip2john to convert to a hash.
+ Used john to crack the hash and obtained the password. [741852963] 
+ Unzipped the `backup.zip` using the newly cracked password.
+ Found the credentials for the website. [admin:qwerty789]
+ The password was an md5 hash & it was found using crackstation.net.
+ Logged in and obtained the cookie called PHPSESSID.

Exploitation 
---------------------
+ Edited the `exploit.py` file with all the required values and ran it to get a shell.

Privilege Escalation
---------------------
+ Ran `linpeas.sh` on the machine to find credentials:
	[postgres:P@s5w0rd!]
+ Using `sudo -l` to find the pg_hba.conf file can be edited using `sudo /bin/vi` without the password.
+ After running the vi command, ESC and `:!/bin/bash` gives root