$(window).ready(function () {

  $(".addChild").click(function () {
    // klonuojame formos eilutę
    rowClone = $(".formRowsContainer").find(".formRow:first").clone(true, true);

    // pašaliname disabled požymius ir paslėpimo klasę
    $(rowClone).find("input[type=text], select").prop('disabled', false);
    $(rowClone).removeClass('d-none');

    // klonuotą eilutę įtraukiame į formos eilučių konteinerį
    rowClone.appendTo($(".formRowsContainer"));

    // paslėpimo klasę pašaliname iš formos antraštės eilutės
    $(".headerRow").removeClass("d-none");

    //
    return false;
  })

  $(".removeChild").click(function () {
    // pašaliname formos eilutę, kuriai priklauso paspaustas mygtukas
    $(this).closest(".formRow").remove();

    // jeigu pašalinta paskutinė eilutė, paslepiame formos antraštę
    if ($(".formRowsContainer") && $(".formRowsContainer").find('.formRow').length == 1) {
      $(".headerRow").addClass("d-none");
    }

    //
    return false;
  })

  $('.datepicker').datetimepicker({
    format:'Y-m-d',
    timepicker:false
  });

  $('.datetimepicker').datetimepicker({
    format:'Y-m-d H:i:s'
  });

});

function showConfirmDialog(module, removeId) {
  var r = confirm("Ar tikrai norite pašalinti!");
  if (r === true) {
    window.location.replace("index.php?module=" + module + "&action=delete&id=" + removeId);
  }
}

function showOrderedServiceConfirmDialog(module, contractId, serviceId, dateFrom) {
     var r = confirm("Ar tikrai norite pašalinti!");
     if (r === true) {
          window.location.replace("index.php?module=" + module + "&action=service_delete&contractId=" + contractId + "&serviceId=" + serviceId + "&dateFrom=" + dateFrom);
     }
}