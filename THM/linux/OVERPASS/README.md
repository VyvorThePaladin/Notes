# Overpass

> Sujit Konapur, November 6th, 2020

------------------------------------

## Enumeration
+ Ran initial nmap scan to find ports and services.
+ Found website running javascript locally and the webpage source hints to a caesar cipher or rotN algo.
+ Playing with the precompiled binaries tells us that the password is rot47'ed and store in .overpass file in the home directory.
+ Ran nikto and gobuster to find interesting directories:
	`nikto -h "$IP" | tee nikto.log` & `gobuster dir -u $IP -w dir-2.3-med.txt`
+ Found `/admin` page loading with `login.js` page.
+ Reviewing `login.js` contains possibly interesting code: `Cookies.set("SessionToken",statusOrCookie)`.
+ Used curl to set this cookie to any arbitrary value: `curl "$IP/admin/" --cookie "SessionToken=any_val"`
+ This gives us a private key locked with a passphrase.
+ Used JohnTheRipper to crack private key passphrase using SSHtoJohn.py and JTR.

## Exploitation
+ Successfully SSHed into the machine using private key.
+ The home directory contains hints to privilege escalate and `user.txt`.

## Privilege Escalation
+ Obtained password from `.overpass` file and ran `sudo -l` for user.
+ User cannot run sudo.
+ Ran `linpeas.sh` to enumerate further. 
+ Found cron job running as root.
+ Write access allowed for `/etc/hosts`, modified `overpass.thm` to attacker IP.
+ Created similar directory structure and in the `buildscript.sh` made `/bin/bash` SUID binary.
+ Monitored the binary using `watch ls -la /bin/bash` to see the changes take place.
+ Served directory using `sudo python -m http.server 80`.
+ Ran `/bin/bash -p` to get root.