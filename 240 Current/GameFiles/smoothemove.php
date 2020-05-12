<!DOCTYPE html>
<!--setInterval(stop(), 60000));

-->
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="gameBackground.css">
	<link rel="stylesheet" type="text/css" href="fallingBlocks.css?v=1">
	<button type = "button" id= "startGameButton" onclick="run('<?php echo $_POST['song']?>','<?php echo $_POST['gameType'] ?>');document.getElementById('startGameButton').remove();">Click me to start game</button>
	<div id = "background" class="gameBackground"></div>
</head>

<body>
	<form action="../EndScreens/Victory Screen/VictoryScreen.php" id="win" method="post">
	<input type="hidden" id = "winScore" name = "score" value=""></form>
	<form action="../EndScreens/LoseScreen/LScreen.php" id="lose" method="post">
	<input type = "hidden" id = "loseScore" name = "score" value=""></form>
	<script src="randomEquation.js"></script>
	<script type="text/javascript">
	//trigger when getCurrTime = 60000
		
		//var d = new Date();
		//var startTime = d.getMilliseconds();
		var gameStyle;
		var go; //this variable will hold the interval for blockCannon. Initialized in start(gap).
		var blockInterval = 1000;
		var counter = 0;
		var blockList = new Array(); //whats 9 + 10?
		var currentScore = 0;
		var missedPoints = 0;
		var maxMissedPoints = 100;
		var iWon = 'win';
	   //var selectedSong = '<%= Session["selectedSong"] %>';// rate of block creation, lower = more blocks\
	   function run(selectedSong, selectedGameType) {
			gameStyle = selectedGameType;
			var sound = new Audio('../MusicPic/' + selectedSong + '.mp3');
			//add event Listener for ended
			switch(selectedSong) {
				case("EverytimeWeTouch"):
					blockInterval = 6000;
					break;
				case("HannahMontana"):
					blockInterval = 5000;
					break;
				case("In_the_Jungle"):
					blockInterval = 4000;
					break;
				case("Revenge"):
					blockInterval = 3000;
					break;
				case("TNT"):
					blockInterval = 2000;
					break;
				case("WhatMakesYouBeautiful"):
					blockInterval = 1000;
					break;
				default:	
					alert("Song not Found");
					break;
			}

			sound.id = "playingSong";
			document.body.appendChild(sound);
			sound.play();
			sound.addEventListener('ended',stop);
			go = setInterval(blockCannon, blockInterval);
			updateScore();
	   }
		function updateScore() {
			document.getElementById("background").innerHTML = "Your current score is " + currentScore + "\n You've missed " + missedPoints + " points so far";
		}
		
		function stop(){
			//if(stopVal != 0){
			clearInterval(go);
			updateHighScore(currentScore);
			document.getElementById('loseScore').value = currentScore;
			document.getElementById('winScore').value = currentScore;
			document.getElementById(iWon).submit();
			//update highscore with php 
		}
		function updateHighScore(newScore){
			var args = {
				score: newScore,
				gameType: "<?php echo $_POST['gameType']?>"
			}
			jQuery.ajax({
   				  type: "POST",
   				  url: '../Misc/update_score.php',
   				  data: JSON.stringify(args)
				});
				console.log("done");
			}

		//Shoot blocks with random equations in random collumns/files.
		function blockCannon() {
			/*newD = new Date();
			if((newD.getMilliseconds() - startTime) > 5600){
				iWon = "win";
				stop();
			}*/
			++counter;
			var currentBlockId = "block" + counter;
			/*
			var wunOrToo = ( Math.floor(Math.random() * Math.floor(2)) )+1;
			if (wunOrToo == 1) randomEquation = generateSubtraction();
			else var randomEquation = generateAddition();
			*/  
			var randomEquation;
			var gameType = '<?php echo $_POST['gameType'] ?>';
			console.log(gameType);
			if(gameType == 'addition'){
				randomEquation = generateAddition();
			} else {
				randomEquation = generateSubtraction();
			}
			makeBlock(currentBlockId, randomEquation);
			var newBlock = {id: currentBlockId, equation: randomEquation};
			blockList.push(newBlock);
		}
		/* make block creates block with a random animation of either blockfall1, blockfall2, or blockfall3. Then appends the object to the webpage and sets the inner html equal to the equation which it holds*/
		function makeBlock(newBlockId, equation) {
			var rand = parseInt(Math.random() * 4) + 1; //create a random number between 1 and 4 inclusive
			var block = document.createElement('div');// block object to be appended to webpage
			block.addEventListener("webkitAnimationEnd", animationEndListener);//event listener that triggers on animation end to delete block
			block.setAttribute("id",newBlockId);
			block.setAttribute("class", "fallingBlocks");
			switch(rand){//random selection of the main animation patterns for the blocks
			case (1) : block.setAttribute("style","animation-name: blockFall1"); break;
			case (2) : block.setAttribute("style","animation-name: blockFall2"); break;
			case (3) : block.setAttribute("style","animation-name: blockFall3"); break;
			default : block.setAttribute("style","animation-name: blockFall4"); break;
			}
			block.setAttribute("color","blue");//creates color value of block
			document.body.appendChild(block);
			//block.setAttribute("style","background-color: turquoise");
			block.innerHTML = equation.fontsize(6);

		}
		function animationEndListener(e) {//when event triggers, removes block from webpage and removes block from blockList
			removeBlockId = e.target.getAttribute("id");
			color = e.target.getAttribute("color");
			for(i = 0; i < blockList.length; i++) {
				if(removeBlockId == blockList[i].id){
					blockList.splice(i,1);
				}
			}
			e.target.remove();
			if(color == "blue") {
				explosion();
				missedPoints += 10;
			}
			updateScore();// updates score counter on webpage
			checkIfGameFinish();// checks if player has missed maximum number of points
		}
		
		function checkIfGameFinish() {// checks if the user has missed the maximum amount of points,if so ends the game and gives score card as alert
			if(missedPoints == maxMissedPoints) {
				iWon = 'lose';
				for (i = 0; i < blockList.length; i++) {
					document.getElementById(blockList[i].id).remove();
				}
				stop();//stops the game 
			}
		}
		function explosion() {
			//randomExplosion = randomInt()
			var explosions = <?php echo explosionOptions();?>;
			var explode = new Audio("../soundEffects/Explosions/" + explosions[Math.floor(Math.random()* (explosions.length - 2) + 2 )]);
			explode.addEventListener("ended",explode.remove());
			explode.play();		
		}
	</script>
	
	<?php 
	function explosionOptions() {
		echo json_encode(scandir("../soundEffects/Explosions"));
	}
	?>
	<textarea id = "userGuess" cols="40" rows="5" onkeypress="checkEntryValue(event)"></textarea>
	<script type="text/javascript">
		var guess = "";
		function checkEntryValue(e) {// if user presses enter then checks the value inside textbox and compares it to the values of the equations inside of blockList to see if the user input is correct, if so then removes block from screen and block list
			if (e.keyCode == 13) {
				e.preventDefault();//prevents enter from performing defualt function
				guess = document.getElementById("userGuess").value;//stores value of user guess
				for(var i = 0; i < blockList.length; i++){//runs through existing blocks to check if they hold value equal to user guess
					if(getAnswer(blockList[i], i) == true) {// if value is equal to a block then deletes that block
							break;
					}	
				}
				document.getElementById("userGuess").value = "";//resets text area to blank

			} 
		}

		function getAnswer(block, iterator) {//checks if user input is equal to the chosen blocks equation value, if so then removes block from screen and blockList Array
			asArray = block.equation.split(" ");//splits and solves the equation stored within the block equation
			num1 = parseInt(asArray[0]);
			symbol = asArray[1];
			num2 = parseInt(asArray[2]);
			if (symbol == "+"){//if addition, then solves as additon
				result = num1 + num2;
			} else {
				result = num1 - num2;
			}
			if(result == parseInt(guess)) {//if user guess is correct then deletes the block and increments and updates score
					elem = document.getElementById(block.id);
					animationName = elem.getAttribute("style");
					console.log("animation name: " + animationName);
					elem.setAttribute("style", "background-color: orchid;" + animationName);
					elem.setAttribute("color", "orchid");//saves color attribute of block as orchid if correct
					blockList.splice(iterator, 1); 
					currentScore += 10;
					updateScore();
					return true;
				}
				else{
					return false;
				}
			}


	</script>
</body>
	</html>
