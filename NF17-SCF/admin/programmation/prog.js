$('.card').on('show.bs.collapse', function (e) {
  console.log(e.currentTarget);
  console.log(e);
})
$('.supprimer').click(function() {

  var id = $(this).closest("tr")[0].id;
  $.ajax({
       url : 'supprimer_calendrier.php', // La ressource ciblée
       type : 'POST', // Le type de la requête HTTP.
       data : 'id=' + id,
       success : function(code_html, statut){
         location.reload(true);
       }
    });
});

$('.modifier').click(function() {
  var id = $(this).closest("tr")[0].id;
  window.location.href = "modifier_calendrier.php?id="+id;
  event.stopPropagation();
});


$('.ajouterprog').click(function() {
  var id_cal = $(this).closest("tr")[0].id;
  var id_train = new URL(window.location.href).searchParams.get("id");
  $.ajax({
       url : 'ajouter_programmation.php',
       type : 'POST',
       data : 'id_cal=' + id_cal +"&id_train="+id_train,
       success : function(code_html, statut){
         location.reload(true);
       }
    });
});

$('.supprimerprog').click(function() {
  var id_cal = $(this).closest("tr")[0].id;
  var id_train = new URL(window.location.href).searchParams.get("id");
  $.ajax({
       url : 'supprimer_programmation.php',
       type : 'POST',
       data : 'id_cal=' + id_cal +"&id_train="+id_train,
       success : function(code_html, statut){
         location.reload(true);
       }
    });
});

$('.assigner').click(function() {
  var id = $(this)[0].id;
  window.location.href = "ajout_programmation.php?id="+id;

  //Pour empecher que ca se déplie
  event.stopPropagation();

});
