$('.supprimer').click(function() {
  var $ligne = $(this).closest("tr").find("td");
  var texts = $ligne.map(function() {
    return $(this).text();
  });
  var text = texts[0] +';'+ texts[1];
  $.ajax({
       url : 'supprimer_lieu.php', // La ressource ciblée
       type : 'POST', // Le type de la requête HTTP.
       data : 'lieu=' + text,
       success : function(code_html, statut){
         location.reload(true);
       }
    });
});

$('.modifier').click(function() {
  var $ligne = $(this).closest("tr").find("td");
  var texts = $ligne.map(function() {
    return $(this).text();
  });
  window.location.href = "modifier_lieu.php?nom="+texts[0]+"&adresse="+texts[1];
});
