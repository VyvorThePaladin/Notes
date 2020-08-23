+ GET Request
	`curl http://10.10.137.0:8081/ctf/get`
+ POST Request with body
	`curl -X POST --data "flag_please" http://10.10.137.0:8081/ctf/post`
+ GET request to fetch cookie
	`curl -c cookies.txt http://10.10.137.0:8081/ctf/getcookie`
+ Set a cookie
	`curl -b 'flagpls=flagpls' http://10.10.137.0:8081/ctf/sendcookie`
