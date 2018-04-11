$('.supprimer').click(function() {
  var $ligne = $(this).closest("tr").find("td");
  var texts = $ligne.map(function() {
    return $(this).text();
  });
  $.ajax({
    url : 'supprimer_gare.php',
    type : 'POST', 
    data : 'id=' + texts[0],
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
  window.location.href = "modifier_gare.php?id="+texts[0];
});
