Ran the following:

1. sudo nmap -sC -sV -oN nmap/intial.nmap 10.10.106.111
2. sudo nmap -sS -oN nmap/syn.nmap 10.10.106.111
3. sudo nmap -A -oN nmap/aggro.nmap 10.10.106.111
4. sudo nmap --script vuln -oN nmap/all_vuln.nmap 10.10.106.111
