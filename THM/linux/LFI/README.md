## Local File Inclusion (LFI)
```
IP = 10.10.152.85
```

+ The main cause of this type of Vulnerability is improper sanitization of the user's input.
+ To test for LFI, URL parameter is needed.
+ Found URL parameter called `page`.
+ Vulnerable to LFI, tested using `../../../etc/passwd`.
+ Found shadow file with hash for root and falcon passwords.
+ Also found id_rsa ssh private key for falcon.
+ Logged in using ssh priv key as falcon, ran linpeas.sh.
+ Found `/bin/journalctl` running as SUID, scoured GTFObins.
+ Followed GTFObins to gain root.