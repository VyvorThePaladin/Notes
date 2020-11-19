# Simple CTF

## Enumeration
+ Ran nmap scan to find open ports and services.
+ Enumerated the FTP service to find hint. (password reuse)
+ Found hint in robots.txt. `/openemr-5_0_1_3`
+ Used gobuster to enumerate directories
+ Found `/simple` running  CMS Made Simple version 2.2.8 susceptible to CVE-2019-9053.

## Exploitation
+ Found an exploit for the CVE on exploitdb, ran it on targeturi to find salt,user,email and hashed pass.
+ SSHed into the machine as mike.
+ Noticed using `sudo -l` that vim runs as root without password.
+ Exploited using `:!sh` option of vim to gain root.
