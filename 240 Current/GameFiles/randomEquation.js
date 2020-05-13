//creates random number
	function getRandomInt(){
		var min = Math.ceil(0);
		var max = Math.floor(10);
		return Math.floor(Math.random() * (max - min+1)) + min;
	}
//creates a random addition problem and returns a string of that function
	function generateAddition(){
	return (getRandomInt()) + " + " + (getRandomInt()) ;}
//creates a random subtraction problem and returns a string of that function
	function generateSubtraction(){
		var a = getRandomInt();
		var b = getRandomInt();
		if (a-b < 0){
			if (b-a >= 0){
				var c = a;
				a = b;
				var b = c;
			}
			else{
				generateSubtraction();
			}
		}
		return (a + " - " + b) 
	}
