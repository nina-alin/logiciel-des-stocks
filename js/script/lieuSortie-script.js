// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#nomLieuSortie_a").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      nomLieuSortie: $("#nomLieuSortie_a").val(),
      tunitegestionFK: $("#tunitegestionFK_a").val(),
      type: 1,
    },
    type: "post",
    url: "../config/lieuSortie-save.php",
    success: function (dataResult) {
      try {
        var dataResult = JSON.parse(dataResult);
      } catch (e) {
        if (e instanceof SyntaxError) {
          alert("Erreur lors de la requête : " + dataResult, true);
        } else {
          alert("Erreur lors de la requête : " + dataResult, false);
        }
      }
      if (dataResult.statusCode == 200) {
        $("#myModalLieuSortieAdd").modal("hide");
        alert("Données correctement ajoutées !");
        location.reload();
      } else if (dataResult.statusCode == 201) {
        alert(dataResult);
      }
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

$(document).on("click", ".update", function (e) {
  var tlieusortiePK = $(this).attr("data-id");
  var nomLieuSortie = $(this).attr("data-nom-lieu");
  var tunitegestionFK = $(this).attr("data-ug-id");
  document.getElementById("afficherUpdateNomLieuSortie").innerHTML =
    "Modifier le lieu de sortie " + nomLieuSortie;
  $("#tlieusortiePK_u").val(tlieusortiePK);
  $("#nomLieuSortie_u").val(nomLieuSortie);
  $("#tunitegestionFK_u").val(tunitegestionFK);
});

$(document).on("click", "#update", function (e) {
  if ($("#nomLieuSortie_u").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      tlieusortiePK: $("#tlieusortiePK_u").val(),
      nomLieuSortie: $("#nomLieuSortie_u").val(),
      tunitegestionFK: $("#tunitegestionFK_u").val(),
      type: 2,
    },
    type: "post",
    url: "../config/lieuSortie-save.php",
    success: function (dataResult) {
      try {
        var dataResult = JSON.parse(dataResult);
      } catch (e) {
        if (e instanceof SyntaxError) {
          alert("Erreur lors de la requête : " + dataResult, true);
        } else {
          alert("Erreur lors de la requête : " + dataResult, false);
        }
      }
      if (dataResult.statusCode == 200) {
        $("#myModalLieuSortieUpdate").modal("hide");
        alert("Données correctement modifiées !");
        location.reload();
      } else if (dataResult.statusCode == 201) {
        alert(dataResult);
      }
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

$(document).on("click", ".delete", function () {
  var tlieusortiePK = $(this).attr("data-id");
  $("#tlieusortiePK_d").val(tlieusortiePK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/lieuSortie-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      tlieusortiePK: $("#tlieusortiePK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalLieuSortieDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Données correctement supprimées !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

// GET
$(document).on("click", ".view", function (e) {
  var tlieusortiePK = $(this).attr("data-id");
  var nomLieuSortie = $(this).attr("data-nom-lieu");
  document.getElementById("afficherViewNomLieuSortie").innerHTML =
    "Liste des produits sortis dans " + nomLieuSortie;
  $.ajax({
    url: "../config/lieuSortie-save.php",
    method: "GET",
    data: {
      type: 4,
      tlieusortiePK: tlieusortiePK,
    },
    success: function (dataResult) {
      $("#lieuSortie_details").html(dataResult);
      $("#myModalLieuSortieView").modal("show");
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
