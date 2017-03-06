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


