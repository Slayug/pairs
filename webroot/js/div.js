//On défini ces deux variables pour gérer l'ajout et réponse pour un questionnaire
var questions_ = new Map();
var answers_ = new Map();
var questionSelected = 0;
/**
*	Permet de avoir quel select l'utilisateur a intéragi en dernier
*	0 --> questions
*	1 --> answers
*/
var selectSelected = -1;

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
	if(selectSelected == 0){
		$("#questions").find(":selected").each(function() {
			elements.set($(this).val(), $(this).text());
			questions_.set($(this).val(), $(this).text());
			$(this).remove();
		});
		/*for(var key of questions_.keys()){
			divQuestions.append('<div class="question question-'+key+'"><h5>'+questions_.get(key)+'</h5><h6>Réponses:</h6></div>');
		}*/
		var divQuestions = $("#questions-questionnaires");
		for(var key of elements.keys()){
			var remove = '<button style="float:right;margin-top:6px;" onclick="removeQuestion('+key+')" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon glyphicon-remove" ></span></button>'
			var click = ' onclick="selectQuestion('+key+')"'
			var answers = '<ul class="sortable" id="answers-question-'+key+'"></ul>'
			divQuestions.append('<div class="question" id="question-'+key+'" '+click+'>'+remove+'<h4>'+elements.get(key)+'</h4><h6>Réponses:</h6>'+answers+'</div>');
			questionSelected = key;
		}
	}else if(selectSelected == 1){
		$("#answers").find(":selected").each(function() {
			elements.set($(this).val(), $(this).text());
		});
		answers_.set(questionSelected, elements);
		var answersList = $('#answers-question-'+questionSelected);
		for(var key of elements.keys()){
			var remove = '<button style="float:right;" onclick="removeAnswer('+questionSelected+','+key+')" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon glyphicon-remove" ></span></button>'
			var sortable = '<span class="add-on"><i class="icon-sortable"></i></span>'
			answersList.append('<li class="ui-state-default" class="answer" id="answer-'+key+'"> '+sortable+' '+elements.get(key)+' '+remove+'</li>');
		}
		//$(function() {
		$("#answers-question-"+questionSelected).sortable();
		$("#answers-question-"+questionSelected).disableSelection();
		//});
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
	for(var key of questions_.keys()){
		var bloc = $("#question-"+key);
		bloc.removeClass('question-selected');
	}
	if(questionSelected != 0){
		var bloc = $("#question-"+questionSelected);
		bloc.addClass('question-selected');
	}
}
/**
*	Permet de définir sur quel select l'utilisateur a intéragi en dernier
*	0 --> questions
*	1 --> answers
*/
function changeSelectMode(type){
	if(type >= 0){
		selectSelected = type;
	}
}
function removeAnswer(idQuestion, idAnswer){
	$('#question-'+idQuestion+' #answer-'+idAnswer).remove();
}
/**
*	supprime le bloc et le remet dans le select
*/
function removeQuestion(id){
	$("#question-"+id).remove();
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