/* Replace a bit of string in a String */
	function Replace(str, oldSubStr, newSubStr) {
		return str.split(oldSubStr).join(newSubStr);
	}
/* Method Trim() */
	function Trim(string){
	   return string.replace(/^\s+|\s+$/g, '');
	}
/* Validate if a string is email, Return true of false */
	function Email(value){
		var emailExpression = /^[a-z 0-9][\w.-]+@\w[\w.-]+\.[\w.-]*[a-z][a-z]$/i;
		return emailExpression.test(value);
	}
/* Delete more of two spaces */
	function DeleteDoubleSpaces(value){
		var valueExpression = /\s+/gi;
		return value.replace(valueExpression, " ");
	}
/* Search a word inside of a string. Return true or false */
	function SearchWord(word, string) {
		word = word.toLowerCase();
		string = string.toLowerCase();
		var result = string.search(word);
		if (result == -1)
			return false;
		else 
			return result;
	}
/* Convert number a money format: 100.000,15 */
	function GetMoneyFormat(value) {
		if (value == "0") return value;
		var arrayData = value.split(".");
		var floatData = ""; if (arrayData.length > 1) floatData = "," + arrayData[arrayData.length - 1];
			arrayData = arrayData[0].split("");
			arrayData.reverse();
		var moneyFormat = "";
		for (var i = arrayData.length - 1; i >= 0; i--) {
			moneyFormat += arrayData[i];
			if (i > 0) {
				var result = (i / 3);
				var result = result - Math.floor(i / 3);
				if (result == 0) {
					moneyFormat += ".";
				}
			}
		}
		moneyFormat += floatData;
		return  moneyFormat;
	}
/* Get value of string with URLFormat */
	function GetURLValue(name, string){
		if(!string) string = window.location.href;
		var regexS = "[\\?&]"+name+"=([^&#]*)";
		var regex = new RegExp ( regexS );
		var tmpURL = string;
		var results = regex.exec( tmpURL );
		if( results == null )
			return"";
		else
			return results[1];
	}