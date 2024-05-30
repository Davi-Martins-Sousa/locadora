/*var header = $("#pills-tab");

$(function() {
    console.log("Página Carregada!");
    $("#includedContent").load('Home.php');
});

$(header).on("click", function(e){
    //setAsActive(e);
    var pageName = e.target.textContent;
    $("#includedContent").load(pageName + '.php');
});*/


var header = $("#header");

$(function() {
    console.log("Página Carregada!");
    $("#includedContent").load('pages/Home.php');
});

$(window).on("load", function(){
    console.log("window Carregada!");
});

function setAsActive(e){
    var active = $('.nav-link.active');
    console.log("Elemento Anterior Ativo: ", active[0].text);
    console.log("Elemento a Ativar: ", e.target.text);
    $(active[0]).removeClass("active");
    $(e.target).addClass("active");
}


$(header).on("click", function(e){
    setAsActive(e);
});
