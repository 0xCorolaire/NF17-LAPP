$('.supprimer').click(function() {
  var $ligne = $(this).closest("tr").find("td");
  var texts = $ligne.map(function() {
    return $(this).text();
  });
  $.ajax({
    url : 'supprimer_arret.php',
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
  window.location.href = "modifier_arret.php?id="+texts[0];
});

$( document ).ready(function() {
  $('#Selection_Train').change(function () {
    var param = 'id=' + $(this).val();
      $('#Selection_arrêt').load('ajout2_arret.php', param);
      console.log(param);
  });
});
