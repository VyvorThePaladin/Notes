python -c "import pty; pty.spawn('/bin/bash')"
stty raw -echo
fg
export TERM=xterm
find / -perm -4000 2>/dev/null


+ Ran initial nmap 
+ HTTP server running on port 3333
+ Ran gobuster on IP:3333
+ Ran nikto
+ /internal is interesting page, allows uploading of files
+ php file extension not allowed
+ Compromised the machine using php reverse shell with working extension
+ Found SUID binaries using find cmd:
	`find / -perm 4000 2>/dev/null`
+ systemctl is oddly SUID
+ Used GTFObins to privesc

