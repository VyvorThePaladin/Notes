# Overpass 2 - Hacked

> Sujit Konapur, November 11, 2020

-------------------------------------

## Enumeration
+ Opened the provided pcap in wireshark.
+ Followed TCP stream to find the attack method used.
+ Netcat doesn't encrypt anything.
+ Cracked hash using salt and rockyou with john.

## Exploitation
+ Logged in using the backdoor created on port 2222.
+ The attacker has left a root priv esc SUID binary in home.
+ Run the bash binary with `-p` option to get root.