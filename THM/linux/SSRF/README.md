## SSRF
```
IP = 10.10.119.219
```

+ SSRF is a vulnerability in web applications whereby an attacker can make further HTTP requests through the server.
+ The main cause of the vulnerability is (as it often is) blindly trusting input from a user.
+ Check for SSRF by passing localhost and port for MySQL DB:
	- `http://127.0.0.1:3306`
	- `http://[::]:3306` (in case the localhost is filtered, try IPv6)
	- `http://:::3306` (flask/Django interpretation)
+ If the IPv6 payloads are detected the IP can be replaced with Decimal and Hexadecimal versions.
