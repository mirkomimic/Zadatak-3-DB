$("#addItemModal").on("hidden.bs.modal", function () {
  $(this).find("form").trigger("reset");
});

// add item
$("#addItemForm").submit(function (e) {
  e.preventDefault();
  const form = $(this).serialize();

  request = $.ajax({
    url: "controler/controlerItem.php",
    type: "post",
    data: form,
  });
  request.done(function (response, status, jqXHR) {
    if (response === "Success") {
      alert("Item added");
      location.reload(true);
    } else {
      console.log("Error adding item" + response);
    }
  });
  request.fail(function (jqXHR, textStatus, error) {
    console.log("Error adding item " + textStatus, error);
  });
});
// delete item
$(".deleteItemForm").submit(function (e) {
  e.preventDefault();
  const form = $(this).serialize();

  request = $.ajax({
    url: "controler/controlerItem.php",
    type: "post",
    data: form,
  });
  request.done(function (response, status, jqXHR) {
    if (response === "Success") {
      alert("Item deleted");
      location.reload(true);
    } else {
      console.log("Error adding item" + response);
    }
  });
  request.fail(function (jqXHR, textStatus, error) {
    console.log("Error adding item " + textStatus, error);
  });
});
