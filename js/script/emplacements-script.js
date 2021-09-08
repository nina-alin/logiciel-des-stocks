// POST
$(document).on("click", "#btn-add", function (e) {
  console.log($("#nomEmplacement").val());
  if ($("#nomEmplacement").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 1,
      nomEmplacement: $("#nomEmplacement").val(),
    },
    type: "post",
    url: "../config/emplacements-save.php",
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
        $("#myModalEmplacementsAdd").modal("hide");
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
  var templacementsPK = $(this).attr("data-id");
  var nomEmplacement = $(this).attr("data-nom");
  $("#templacementsPK_u").val(templacementsPK);
  $("#nomEmplacement_u").val(nomEmplacement);
});

$(document).on("click", "#update", function (e) {
  if ($("#nomEmplacement_u").val() == "") {
    alert("Le nom ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      type: 2,
      templacementsPK: $("#templacementsPK_u").val(),
      nomEmplacement: $("#nomEmplacement_u").val(),
    },
    type: "post",
    url: "../config/emplacements-save.php",
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
        $("#myModalEmplacementsUpdate").modal("hide");
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
  var templacementsPK = $(this).attr("data-id");
  $("#templacementsPK_d").val(templacementsPK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/emplacements-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      templacementsPK: $("#templacementsPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalEmplacementsDelete").modal("hide");
      $("#" + dataResult).remove();
      alert("Données correctement supprimées !");
      document.location.reload();
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
