// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#nomPlateforme").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 1,
      nomPlateforme: $("#nomPlateforme").val(),
    },
    type: "post",
    url: "../config/plateforme-save.php",
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
        $("#myModalPlateformeAdd").modal("hide");
        alert("Données ajoutées avec succès !");
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

// UPDATE
$(document).on("click", ".update", function (e) {
  var tplateformePK = $(this).attr("data-id");
  var nomPlateforme = $(this).attr("data-nom");
  $("#tplateformePK_u").val(tplateformePK);
  $("#nomPlateforme_u").val(nomPlateforme);
});

$(document).on("click", "#update", function (e) {
  if ($("#nomPlateforme_u").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 2,
      tplateformePK: $("#tplateformePK_u").val(),
      nomPlateforme: $("#nomPlateforme_u").val(),
    },
    type: "post",
    url: "../config/plateforme-save.php",
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
        $("#myModalPlateformeUpdate").modal("hide");
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

// DELETE
$(document).on("click", ".delete", function () {
  var tplateformePK = $(this).attr("data-id");
  $("#tplateformePK_d").val(tplateformePK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/plateforme-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      tplateformePK: $("#tplateformePK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalPlateformeDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Données correctement supprimées !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
