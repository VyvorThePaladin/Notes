# LazyAdmin
## Enumeration
+ Ran initial nmap scan to find SSH and apache running.
+ Ran gobuster to find `/content`.
+ Hints to a CMS called sweetrice.
+ Using searchsploit found a trivial method to dump SQL backup.
+ Found credentials in the SQL dump.

# Exploitation
+ Logged into `/content/as/index.php` admin controls.
+ Found a location to upload plugins as zip files.
+ Zipped a modified reverse shell php script from pentestermonkey.
+ Uploaded zip and navigated to `/content/_plugin/` to launch script.
+ Caught reverse shell in attacker listener.

# Privilege Escalation
+ Ran `sudo -l` to find backdoor already configure to run.
+ Ran and got root.