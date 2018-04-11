$('.supprimer').click(function() {
  var $ligne = $(this).closest("tr").find("td");
  var texts = $ligne.map(function() {
    return $(this).text();
  });
  $.ajax({
    url : 'supprimer_t_train.php',
    type : 'POST',
    data : 'nom=' + texts[0],
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
  window.location.href = "modifier_t_train.php?nom="+texts[0];
});
