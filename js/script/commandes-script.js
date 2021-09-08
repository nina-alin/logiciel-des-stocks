// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#dateCommande_a").val() == "" || $("#numeroCommande_a").val() == "") {
    alert("Un champ ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      numeroCommande: $("#numeroCommande_a").val(),
      dateCommande: $("#dateCommande_a").val(),
      arrivee: $('input[name="arrivee_a"]:checked').val(),
      type: 1,
    },
    type: "post",
    url: "../config/commande-save.php",
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
        $("#myModalCommandeAdd").modal("hide");
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

// UPDATE
$(document).on("click", ".update", function (e) {
  var tcommandesPK = $(this).attr("data-id");
  var numeroCommande = $(this).attr("data-numero");
  var dateCommande = $(this).attr("data-date");
  var arrivee = $(this).attr("data-arrivee");
  document.getElementById("afficherUpdateNumeroCommande").innerHTML =
    "Modifier la commande n°" + numeroCommande;
  $("#tcommandesPK_u").val(tcommandesPK);
  $("#numeroCommande_u").val(numeroCommande);
  $("#dateCommande_u").val(dateCommande);
  $('input[name="arrivee_u"]:checked').val(arrivee);
});

$(document).on("click", "#update", function (e) {
  if (
    $("#dateCommande_u").val() == "" ||
    $("#numeroCommande_u").val() == "" ||
    $('input[name="arrivee_u"]:checked').val() == null
  ) {
    alert("Un champ ne peut pas être vide !");
    return e;
  }
  $.ajax({
    data: {
      tcommandesPK: $("#tcommandesPK_u").val(),
      numeroCommande: $("#numeroCommande_u").val(),
      dateCommande: $("#dateCommande_u").val(),
      arrivee: $('input[name="arrivee_u"]:checked').val(),
      type: 2,
    },
    type: "post",
    url: "../config/commande-save.php",
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
        console.log(dataResult);
        $("#myModalCommandeUpdate").modal("hide");
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
  var tcommandesPK = $(this).attr("data-id");
  $("#tcommandesPK_d").val(tcommandesPK);
});

$(document).on("click", "#delete", function () {
  $.ajax({
    url: "../config/commande-save.php",
    type: "POST",
    cache: false,
    data: {
      type: 3,
      tcommandesPK: $("#tcommandesPK_d").val(),
    },
    success: function (dataResult) {
      $("#myModalCommandeDelete").modal("hide");
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
  var tcommandesPK = $(this).attr("data-id");
  var numeroCommande = $(this).attr("data-numero");
  document.getElementById("afficherViewNumeroCommande").innerHTML =
    "Produits de la commande n°" + numeroCommande;
  $.ajax({
    url: "../config/commande-save.php",
    method: "GET",
    data: {
      type: 4,
      tcommandesPK: tcommandesPK,
    },
    success: function (dataResult) {
      $("#produitsCommandeList").html(dataResult);
      $("#myModalCommandeView").modal("show");
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});
