# OOPSIE 
```
IP = 10.10.10.28
```

Enumeration
---------------------
+ Ran initial nmap and all vuln scan.
+ After examining the source of the webpage, found a login page at:
	`http://10.10.10.28/cdn-cgi/login/`
+ The previous box ARCHETYPE's credentials works here too. [admin:MEGACORP_4dm1n!!]
+ The page needs a super admin to upload files.
+ Enumerating the url parameter `id` on the Account tab gives us the access ID for super admin. [86575]

Exploitation 
---------------------
+ Now we can upload the reverse php shell script for port 9001.
+ Going to `http://10.10.10.28/uploads/php-reverse-shell.php` gets us a reverse shell on our listener.
+ The file db.php present at location `/var/www/html/cdn-cgi/login` yields credentials. [robert:M3g4C0rpUs3r!], the file was found after exploring the home folder.
+ Now we can SSH into the box as robert.

Privilege Escalation
---------------------
+ We can see that robert belongs to group `bugtracker`.
+ Looking for other files that belong to the group:
	`find / -group bugtracker 2>/dev/null`
+ Found a SUID binary called bugtracker.
+ Performed strings on it and saw that full path is not used to execute commands. 
+ So created a file called `cat` and gave it executable permissions.
+ Ran the SUID binary to gain root.