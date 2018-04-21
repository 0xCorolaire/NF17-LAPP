$('.supprimer').click(function() {
  var $ligne = $(this).closest("tr").find("td");
  var texts = $ligne.map(function() {
    return $(this).text();
  });
  $.ajax({
    url : 'supprimer_train.php',
    type : 'POST', 
    data : 'numero=' + texts[0],
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
  window.location.href = "modifier_train.php?numero="+texts[0];
});
