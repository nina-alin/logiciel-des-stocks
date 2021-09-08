var globalNs; // variable globale pour stocker l'id pour les numéros de séries

// quand on choisi d'ajouter un numéro de série, cette fonction se lance
function showHiddenContentNs() {
  document.getElementById("addns").innerHTML =
    '<input type="hidden" id="tnumerosseriesPK_a" name="tnumerosseriesPK_a" name="type"><table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;"><tr><th>Numéro de série</th><td><input id="numeroSerie_a" name="numeroSerie_a"></td></tr></table><button type="submit" class="btn btn-warning" id="btn-add-ns" title="Ajouter">Ajouter</button>';
}

$(document).on("click", ".add", function (e) {
  var tproduitsstockesPK = $(this).attr("data-id");
  var nomModele = $(this).attr("data-modele");
  var nomFabricant = $(this).attr("data-fabricant");
  document.getElementById("afficherAddSortie").innerHTML =
    "Ajouter une entrée pour " + nomFabricant + "&nbsp;" + nomModele;
  $("#tproduitsstockesFK_a").val(tproduitsstockesPK);
});

// POST
$(document).on("click", "#btn-add", function (e) {
  if ($("#quantiteEntree_a").val() == "") {
    alert("La quantité ne peut pas être vide.");
    return e;
  }
  if (document.getElementById("typeEntree").value == 1) {
    if ($("#tcommandesFK_a").val() == undefined) {
      alert(
        "La numéro de commande ne peut pas être vide. Merci d'en ajouter un dans la page \"commandes\" avant d'entrer un produit."
      );
      return e;
    }
    $.ajax({
      data: {
        quantiteEntree: $("#quantiteEntree_a").val(),
        tproduitsstockesFK: $("#tproduitsstockesFK_a").val(),
        tcommandesFK: $("#tcommandesFK_a").val(),
        ttechnicienFK: $("#ttechnicienFK_a").val(),
        type: 1,
      },
      type: "post",
      url: "../config/stocks-save.php",
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
          $("#myModaltentreeAdd").modal("hide");
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
  } else if (document.getElementById("typeEntree").value == 2) {
    $.ajax({
      data: {
        quantiteEntree: $("#quantiteEntree_a").val(),
        tproduitsstockesFK: $("#tproduitsstockesFK_a").val(),
        ttechnicienFK: $("#ttechnicienFK_a").val(),
        tlieusortieFK: $("#tlieusortieFK_a").val(),
        type: 8,
      },
      type: "post",
      url: "../config/stocks-save.php",
      success: function (dataResult) {
        console.log(dataResult);
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
          $("#myModaltentreeAdd").modal("hide");
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
  }
});

// UPDATE
$(document).on("click", ".update", function (e) {
  var tproduitsstockesPK = $(this).attr("data-id");
  var tlibellesFK = $(this).attr("data-libelles");
  var alerte = $(this).attr("data-alerte");
  $("#tproduitsstockesPK_u").val(tproduitsstockesPK);
  $("#tlibellesFK_u").val(tlibellesFK);
  $("#alerte_u").val(alerte);
  var nomModele = $(this).attr("data-modele");
  var nomFabricant = $(this).attr("data-fabricant");
  document.getElementById("afficherModifierProduit").innerHTML =
    "Modifier " + nomFabricant + "&nbsp;" + nomModele;
});

$(document).on("click", "#update", function (e) {
  if ($('input[name="alerte_u"]:checked').val() == null) {
    alert("Sélectionnez une alerte !");
    return e;
  }
  $.ajax({
    data: {
      type: 2,
      alerte: $('input[name="alerte_u"]:checked').val(),
      tlibellesFK: $("#tlibellesFK_u").val(),
      tproduitsstockesPK: $("#tproduitsstockesPK_u").val(),
    },
    type: "post",
    url: "../config/stocks-save.php",
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
        $("#myModalStocksUpdate").modal("hide");
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

$(document).on("click", ".sortie", function (e) {
  var tproduitsstockesPK = $(this).attr("data-id");
  $("#tproduitsstockesPK_s").val(tproduitsstockesPK);
  var nomModele = $(this).attr("data-modele");
  var nomFabricant = $(this).attr("data-fabricant");
  document.getElementById("afficherSortirProduit").innerHTML =
    "Sortir " + nomFabricant + "&nbsp;" + nomModele;
});

$(document).on("click", "#btn-sortie", function (e) {
  if ($(quantiteSortie_s).val() == "") {
    alert("Entrer une quantité de sortie !");
    return e;
  }
  $.ajax({
    data: {
      raisonSortie: $("#raisonSortie_s").val(),
      quantiteSortie: $("#quantiteSortie_s").val(),
      ttechnicienFK: $("#ttechnicienFK_s").val(),
      tlieusortieFK: $("#tlieusortieFK_s").val(),
      quantite: $("#quantite_s").val(),
      tproduitsstockesPK: $("#tproduitsstockesPK_s").val(),
      type: 3,
    },
    type: "post",
    url: "../config/stocks-save.php",
    success: function (dataResult) {
      console.log(dataResult);
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
        $("#myModalStocksSortie").modal("hide");
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

// GET
$(document).on("click", ".view", function (e) {
  var tproduitsstockesPK = $(this).attr("data-id");
  var nomModele = $(this).attr("data-nom");
  var nomFabricant = $(this).attr("data-fabricant");
  document.getElementById("afficherViewNomStocks").innerHTML =
    "Caractéristiques de " + nomFabricant + " " + nomModele;
  $.ajax({
    url: "../config/stocks-save.php",
    method: "GET",
    data: {
      type: 4,
      tproduitsstockesPK: tproduitsstockesPK,
    },
    success: function (dataResult) {
      $("#stocks_details").html(dataResult);
      $("#myModalStocksView").modal("show");
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

function typeEntreeFunction() {
  if (document.getElementById("typeEntree").value == 1) {
    $.ajax({
      url: "../config/stocks-save.php",
      method: "GET",
      data: {
        type: 5,
      },
      success: function (dataResult) {
        $("#trTypeEntree").html(dataResult);
      },
    });
  } else if (document.getElementById("typeEntree").value == 2) {
    $.ajax({
      url: "../config/stocks-save.php",
      method: "GET",
      data: {
        type: 6,
      },
      success: function (dataResult) {
        $("#trTypeEntree").html(dataResult);
      },
    });
  }
  $("#trQuantite").html(
    "<th>Quantité</th>" +
      "<td>" +
      '<input type="number" class="form-control" id="quantiteEntree_a" name="quantiteEntree_a" min="1" onchange="quantiteNumeroSerieFunction();" required>' +
      "</td>" +
      "</tr>"
  );
  $.ajax({
    url: "../config/stocks-save.php",
    method: "GET",
    data: {
      type: 7,
    },
    success: function (dataResult) {
      $("#trTechnicien").html(dataResult);
    },
  });
}

$(document).on("click", ".update-ns", function (e) {
  var tproduitsstockesPK = $(this).attr("data-id");
  globalNs = tproduitsstockesPK;
  var nomModele = $(this).attr("data-modele");
  var nomFabricant = $(this).attr("data-fabricant");
  document.getElementById("afficherNsProduit").innerHTML =
    "Numéros de séries des produits " + nomFabricant + "&nbsp;" + nomModele;
  $.ajax({
    url: "../config/stocks-save.php",
    method: "GET",
    data: {
      type: 9,
      tproduitsstockesPK: tproduitsstockesPK,
    },
    success: function (dataResult) {
      $("#numeroseries_details").html(dataResult);
      $("#myModaltnumerosserieUpdate").modal("show");
    },
    error: function (request, status, error) {
      alert(request.responseText);
    },
  });
});

$(document).on("click", ".crayon-ns", function (e) {
  var tnumerosseriesPK = $(this).attr("data-id");
  var numeroSerie = $("#numeroSerie_u_" + tnumerosseriesPK).val();
  if (numeroSerie == "") {
    alert("Entrer un numéro de série !");
    return e;
  }
  $.ajax({
    url: "../config/stocks-save.php",
    method: "POST",
    data: {
      type: 10,
      tnumerosseriesPK: tnumerosseriesPK,
      numeroSerie: numeroSerie,
    },
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
        $("#myModaltnumerosserieUpdate").modal("hide");
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

// DELETE NUMERO DE SERIE
$(document).on("click", ".delete-ns", function (e) {
  var tnumerosseriesPK = $(this).attr("data-id");
  $.ajax({
    data: {
      type: 11,
      tnumerosseriesPK: tnumerosseriesPK,
    },
    type: "post",
    url: "../config/stocks-save.php",
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

// ADD NUMERO SERIE
$(document).on("click", "#btn-add-ns", function (e) {
  if ($("#numeroSerie_a").val() == "") {
    alert("Entrer un numéro de série !");
    return e;
  }
  $.ajax({
    data: {
      type: 12,
      numeroSerie: $("#numeroSerie_a").val(),
      tproduitsstockesFK: globalNs,
    },
    type: "post",
    url: "../config/stocks-save.php",
    success: function (dataResult) {
      console.log(dataResult);
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
