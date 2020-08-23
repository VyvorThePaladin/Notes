# ZTH: ONSCURE WEB VULNS
```
IP_1 = 10.10.119.221
IP_2 = 10.10.206.42
IP_3 = 10.10.243.35
IP_4 = 10.10.12.129
```

### SSTI
-------------------------
+ Server Side Template Injection, is when a user is able to pass in a parameter that can control the template engine that is running on the server.

	- Test for SSTI using {{2+2}}
	- Automated Tool: `tplmap`

### CSRF
-------------------------
+ Cross Site Request Forgery, known as CSRF occurs when a user visits a page on a site, that performs an action on a different site.

	- Automated Tool: `xsrfprobe`

### JWT
-------------------------
+ The basic structure of a Json Web Token is  "header.payload.secret", the secret is only known to the server, and is used to make sure that data wasn't changed along the way. A typical JWT header looks like `{"typ":"JWT","alg":"RS256"}`. "none" JWT

	- Difficult to automate.
	- Requires server's public key to sign JWT
	- JWT can be bruteforced using `jwt-cracker`

### XXE
-------------------------
+ XXE is when an attacker is able to use the ENTITY feature of XML to load resources from outside the website directory, for example XXE would allow an attack to load the contents of /etc/passwd.
	
	- Difficult to automate.
	- Can be used to RCE using PHP's expect
