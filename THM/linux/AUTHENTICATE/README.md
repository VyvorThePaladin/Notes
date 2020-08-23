## AUTHENTICATE
```
IP = 10.10.251.215
```

Dictionary Attack
-------------------
+ Performed dictionary attack using ZAP for users jack and mike.
+ Successfully logged in and obtained their secrets.

Re-registration
-------------------
+ Registering a new user with an existing username by inserting spaces.
+ Gave access to darren and arthur's secrets.

JSON Web Token
-------------------
+ Manipulated JWT to change header's alg field to none and changed payload to enter different user's page.
+ Remeber header.payload.secret

No Auth
-------------------
Just changing the number can authenticate you to a different user's account.