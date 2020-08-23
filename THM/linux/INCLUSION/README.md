## INCLUSION

```
IP = 10.10.119.147
```

+ Found LFI in URL parameter called `name` using `../../../etc/passwd`.
+ Found creds [falconfeast:rootpassword] in `/etc/passwd` file.
+ SSHed into it to find user flag.
+ Found a SUID binary using `sudo -l` at `/usr/bin/socat`.
+ Used GTFObins to gain root using `sudo socat stdin exec:/bin/sh` and got root flag.