# Lian Yu
## Enumeration
+ Ran initial nmap scan to enumerate ports and services.
+ Ran gobuster to enumerate directories.
+ Found hint at `/island` path. [vigilante]
+ The username for ftp is known.
+ Ran gobuster on `/island` and found `/island/2100` with a new hint. [.ticket]
+ Ran a ext based gobuster scan for `.ticket` extension.
+ Found login creds to ftp server.
+ Downloaded few images off the ftp server.

## Exploitation
+ One of the images had a wrong header for PNG format.
+ Fixed the header using `hexeditor`.
+ Got the passphrase to decode second image.
+ Got SSH creds after extracting zip using `steghide`.
+ SSHed into the box as user `slade`.

## Privilege Escalation
+ Ran `sudo -l` and found `pkexec` can be run as sudo.
+ Used GTFOBins to find payload for `pkexec`.
+ Ran payload command to get root.