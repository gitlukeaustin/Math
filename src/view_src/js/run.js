$(document).ready(function(){
                  /* Change l'affichage du tableau. */
                  $("#selector").change(function(){
                                        
                                        var texte = $("#selector option:selected").text();
                                        jQuery.ajax({
                                                    url:"index.php?action="+texte,
                                                    success: function(result)
                                                    {
                                                    $("#table").html(result);
                                                    $("#explication").html(getExplication(texte));
                                                    }
                                                    });
                                        });
                  });

function getExplication(texte)
{
    switch(texte)
    {
        case 'Distribution':
            return " Y: Voteurs \\ X: Matières";
            break;
        case 'Points':
            return " Y: Elèves \\ X: Matières";
            break;
        case 'Poids':
            return " Y: Elèves \\ X: Matières";
            break;
        case 'Euler':
            return " Y: Voteurs \\ X: Matières  (Formule: -log(p(voter pour un élève dans une matière))";
            break;
        default:
            return "";
            break;
    }
}

/* Génère le graphe CanvasJS représentant l'écart entre la surprise des votes d'un élève et la surprise optimale. */
function makeGraphe(eleve)
{
    if((eleve=="total")||(eleve=="palmarès")||(eleve=="surprise minimum"))
    {
        return false;
    }
	var send = {etudiant:eleve};
	jQuery.ajax({
		url:"index.php?action=graphe",
		method:"post",
		data:send,
		success: function(result)
		{
			$("html, body").animate({ scrollTop: $(document).height() }, "slow");
			var chart = new CanvasJS.Chart("graphe",
			{
				theme:"theme2",
				title:{
					text:"Entropie de "+eleve
				},
				animationEnabled:true,
				data:[{
					type:"column",
					dataPoints: JSON.parse(result)
        
				}]
			});
			chart.render();
			
		}
});


}


