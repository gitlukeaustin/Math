$(document).ready(function(){
                  console.log("hi");
                  console.log($("#selector option:selected").text());
                  $("#selector").change(function(){
                                        
                                        console.log("here");
                                        var texte = $("#selector option:selected").text();
                                        console.log(texte);
                                        jQuery.ajax({
                                                    url:"index.php?action="+texte,
                                                    success: function(result)
                                                    {
                                                    console.log(result);
                                                    $("#table").html(result);
                                                    }
                                                    });
                                        });
                  });


function makeGraphe(eleve)
{
	var send = {etudiant:eleve};
	jQuery.ajax({
		url:"index.php?action=graphe",
		method:"post",
		data:send,
		success: function(result)
		{
			
			console.log(result);
			var chart = new CanvasJS.Chart("graphe",
			{
				theme:"theme2",
				title:{
					text:eleve
				},
				animationEnabled:false,
				data:[{
					type:"column",
					dataPoints: [
						{label:"apple",y:10},
						{label:"orange",y:26}
						]			
				}]
			});
			chart.render();
			
		}
});


}


