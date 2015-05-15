//On défini ces deux variables pour gérer l'ajout et réponse pour un questionnaire
var questions_ = new Map();
var answers_ = new Map();
var questionSelected = 0;

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
function submitDiv(div){
	document.getElementById(div).submit();
}
function insertQuestion(title, type){

}
function insertAnswer(title){

}
function arrowRight(){
	var elements = new Map();
	$("#questions").find(":selected").each(function() {
		elements.set($(this).val(), $(this).text());
		questions_.set($(this).val(), $(this).text());
		$(this).remove();
    });
	/*for(var key of questions_.keys()){
		divQuestions.append('<div class="question question-id-'+key+'"><h5>'+questions_.get(key)+'</h5><h6>Réponses:</h6></div>');
	}*/
	var divQuestions = $("#questions-questionnaires");
	for(var key of elements.keys()){
		var remove = '<button onclick="removeQuestion('+key+')" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon glyphicon-remove" ></span></button>'
		var click = ' onclick="selectQuestion('+key+')"'
		divQuestions.append('<div class="question" id="question-id-'+key+'" '+click+'>'+remove+'<h5>'+elements.get(key)+'</h5><h6>Réponses:</h6></div>');
		questionSelected = key;
	}
	updateQuestionSelected();
}
function arrowLeft(){
}
function selectQuestion(idQuestion){
	questionSelected = idQuestion;
	updateQuestionSelected();
}
function updateQuestionSelected(){
	if(questionSelected != 0){
		for(var key of questions_.keys()){
			var bloc = $("#question-id-"+key);
			bloc.css("background-color", 'white');
		}
		var bloc = $("#question-id-"+questionSelected);
		bloc.css( "background-color", '#e16244');
	}
}
/**
*	supprime le bloc et le remet dans le select
*/
function removeQuestion(id){
	$("#question-id-"+id).remove();
	var strQuestion = questions_.get(id+"");
	var select = $("#questions");
	select.append('<option value="'+id+'">'+strQuestion+'</option>');
	questions_.delete(id+"");
}
/**
*	Permet d'ajouter un élément dans un select depuis un input text
*	SELECT DIV ID: elements
*	INPUT DIV ID: add-element
*/
function addElement(element){
	var newElement = $("#add-"+element).val();
	var newId = $('select#'+element+'s option').length + 1;
	var select = $("#"+element+"s");
	select.append('<option value="'+newId+'">'+newElement+'</option>');
}