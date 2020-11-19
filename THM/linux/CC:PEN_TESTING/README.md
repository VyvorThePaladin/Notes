# CC: Pen Testing

## Enumeration
+ Ran nmap on target.
+ Found apache running on port 80.
+ Found hidden file at `/secret/secret.txt` using gobuster.
+ Contained hashed creds: `nyan:046385855FC9580393853D8E81F240B66FE9A7B8`
+ Cracked hash to get user creds.
+ Ran `sudo -l` to check privileges, nyan can run sudo su.
+ Privilege escalated to get root.
