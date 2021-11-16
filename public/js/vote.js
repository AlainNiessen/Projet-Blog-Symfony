
$(function () {

    // événement sur les deux boutons => un click va appeler la fonction requeteAjax, 
    // qui va lancer une requete Ajax vers la route article/actionVote pour y récupérer une valeur aléatoire entre 1 et 100
    // cette valeur va remplacer la valeur actuelle de votes 
    $('#votes_plus, #votes_moins').on('click',() => {
        requeteAjax();        
    })   
})

function requeteAjax() {
    $.ajax({
        url: window.location.origin + '/article/actionVote',
        dataType : 'json',        
        success: (data) => {
            //actualisation de votes pour un article
            $('#nombre_votes').text(data.votes);
        }
    })
}







