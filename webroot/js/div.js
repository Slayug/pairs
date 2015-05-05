//On défini ces deux variables pour gérer l'ajout et réponse pour un questionnaire
var questions_ = [];
var answers_ = [];

function spawnDivAndInnerUrl(divId, url){
	var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200) {
			div = spawnDiv(divId);
			div.innerHTML = xhr.responseText;
		}
    };
	xhr.send(null);
}
function spawnDivAndInnerContent(divId, content){
	div = spawnDiv(divId);
	div.innerHTML = content;
}
function spawnDiv(divName){
	var div = document.getElementById(divName);
	div.className = "startMove";
	if(divName == "field_registration"){
		divContent = document.getElementById("registration");
		//divContent.style.width = "18%";
		//div.style.width ="20%";
	}
	return div;
}
function closeDiv(divName){
	var div = document.getElementById(divName);
	if(div == null){
		window.location = "index.php";
	}
	div.className = "initMove";
	div.innerHTML = "";
	div.style.height="auto";
}
function keyDown(event, div){
	if(event.keyCode == 13){
		document.getElementById(div).submit();
	}
}
function submitDiv(div){
	document.getElementById(div).submit();
}
function insertQuestion(title, type){

}
function insertAnswer(title){

}
function arrowRight(){
	var elements = [];
	$("#questions").find(":selected").each(function() {
		elements.splice(elements.length, 0, $(this).text());
    });
	var divQuestions = $("#questions-questionnaires");
	for(var i = 0; i < elements.length; i++){
		divQuestions.append('<div class="question"><h5>'+elements[i]+'</h5><h6>Réponses:</h6></div>');
		
	}
}
function arrowLeft(){
	console.log("coucouleft");

}