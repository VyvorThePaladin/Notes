# Agent Sudo
## Enumeration
+ Ran initial nmap scan to find open ports and services.
+ FTP, SSH and Apache running on the box.
+ Found secret redirection with the help of Burp Suite's Repeater and Intruder modules.
+ Connected to ftp as chris after brute forcing his password using hydra.
+ Found two images and a hint.
+ Got a zip off the image using binwalk and bruteforced the zip password using john.
+ Zip contains hint and base64'd secret.
+ Used secret to obtain SSH password in the other photo.

## Exploitation
+ Logged into `james` account to find a new image.

## Privilege Escalation
+ Checked permissions using `sudo -l` to get `(ALL, !root) /bin/bash`.
+ Interesting! Googled the output to find the following payload: `sudo -u#-1 /bin/bash`.
+ Ran payload and got root.