$("#addItemModal").on("hidden.bs.modal", function () {
  $(this).find("form").trigger("reset");
});
$("#editItemModal").on("hidden.bs.modal", function () {
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
      location.reload(true);
      alert("Item added");
    } else {
      console.log("Error adding item" + response);
    }
  });
  request.fail(function (jqXHR, textStatus, error) {
    console.log("Error adding item " + textStatus, error);
  });
});

// delete item
$(document).on("submit", ".deleteItemForm", function (e) {
  e.preventDefault();

  if (confirm("Are you sure?") == false) {
    return;
  }

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

// ucitaj item
$("#btn_edit_item").click(function (e) {
  e.preventDefault();

  var id = $(".selectedItem form > #item_id").val();

  request = $.ajax({
    url: "controler/findItem.php",
    type: "post",
    data: { item_id: id },
  });

  request.done(function (response, textStatus, jqXHR) {
    var response = JSON.parse(response);

    $("#floatingInputId2").val(response.id);
    $("#floatingInputName2").val(response.name);
    $("#floatingInputPrice2").val(response.price);

    $("#editItemForm select option").each(function () {
      if ($(this).val() == response.category) {
        $(this).attr("selected", "selected");
      }
    });
  });

  request.fail(function (jqXHR, textStatus, error) {
    console.log("Desila se greska: " + textStatus, error);
  });
});

// edit item
$("#editItemForm").submit(function (e) {
  e.preventDefault();
  const form = $(this).serialize();
  console.log(form);
  request = $.ajax({
    url: "controler/editItem.php",
    type: "post",
    data: form,
  });
  request.done(function (response, status, jqXHR) {
    console.log(response);
    if (response === "Success") {
      location.reload(true);
      alert("Item added");
    } else {
      console.log("Error adding item" + response);
    }
  });
  request.fail(function (jqXHR, textStatus, error) {
    console.log("Error adding item " + textStatus, error);
  });
});

// selektuj item
$(document).on("click", ".card", function () {
  // $(".card").on("click", function () {
  $(this).toggleClass("selectedItem").siblings().removeClass("selectedItem");
  // });
});

// select filter
// $("#select_filter").change(function () {
//   const restaurant_id = $("#restaurant_id").val();

//   request = $.ajax({
//     url: "controler/getItemsByPriceDesc.php",
//     type: "post",
//     data: { restaurant_id: restaurant_id },
//   });

//   request.done(function (response, textStatus, jqXHR) {
//     var response = JSON.parse(response);
//     console.log(response);

//     $("#gridItems").empty();

//     for (var i = 0; i < response.length; i++) {
//       card = `
//       <div class="card width-18 text-center bg-card">
//         <p>Name: ${response[i].name} </p>
//         <p>Price: ${response[i].price} </p>
//         <p>Category: ${response[i].category} </p>
//         <div class="m-2">
//           <form action="" class="deleteItemForm" name="deleteItemForm">
//             <input type="text" id="item_id" name="item_id" value="${response[i].id}" hidden>
//             <input type="text" name="restaurant_id" value="${restaurant_id}" hidden>
//             <input type="submit" class="btn btn-outline-danger btn-sm" value="Delete">
//           </form>
//         </div>
//       </div>`;

//       $("#gridItems").append(card);
//     }
//   });

//   request.fail(function (jqXHR, textStatus, error) {
//     console.log("Desila se greska: " + textStatus, error);
//   });
// });

// select filter
$(document).on("change", "#select_filter", function () {
  const restaurant_id = $("#restaurant_id").val();

  var selectedValue = $(this).find(":selected").val();

  if (selectedValue == "priceDesc") {
    request = $.ajax({
      url: "controler/getItemsByPriceDesc.php",
      type: "post",
      data: { restaurant_id: restaurant_id },
    });
  } else if (selectedValue == "priceAsc") {
    request = $.ajax({
      url: "controler/getItemsByPriceAsc.php",
      type: "post",
      data: { restaurant_id: restaurant_id },
    });
  }
  request.done(function (response, textStatus, jqXHR) {
    var response = JSON.parse(response);

    $("#gridItems").empty();

    for (var i = 0; i < response.length; i++) {
      card = `
      <div class="card width-18 text-center bg-card">
        <p>Name: ${response[i].name} </p>
        <p>Price: ${response[i].price} </p>
        <p>Category: ${response[i].category} </p>
        <div class="m-2">
          <form action="" class="deleteItemForm" name="deleteItemForm">
            <input type="text" id="item_id" name="item_id" value="${response[i].id}" hidden>
            <input type="text" name="restaurant_id" value="${restaurant_id}" hidden>
            <input type="submit" class="btn btn-outline-danger btn-sm" value="Delete">
          </form>
        </div>
      </div>`;

      $("#gridItems").append(card);
    }
  });

  request.fail(function (jqXHR, textStatus, error) {
    console.log("Desila se greska: " + textStatus, error);
  });
});

// text filter
$(document).on("keyup", "#search_input", function () {
  const restaurant_id = $("#restaurant_id").val();

  var searchValue = $(this).val();

  request = $.ajax({
    url: "controler/getItemsByName.php",
    type: "post",
    data: { restaurant_id: restaurant_id, searchValue: searchValue },
  });
  request.done(function (response, textStatus, jqXHR) {
    var response = JSON.parse(response);

    $("#gridItems").empty();

    for (var i = 0; i < response.length; i++) {
      card = `
      <div class="card width-18 text-center bg-card">
        <p>Name: ${response[i].name} </p>
        <p>Price: ${response[i].price} </p>
        <p>Category: ${response[i].category} </p>
        <div class="m-2">
          <form action="" class="deleteItemForm" name="deleteItemForm">
            <input type="text" id="item_id" name="item_id" value="${response[i].id}" hidden>
            <input type="text" name="restaurant_id" value="${restaurant_id}" hidden>
            <input type="submit" class="btn btn-outline-danger btn-sm" value="Delete">
          </form>
        </div>
      </div>`;

      $("#gridItems").append(card);
    }
  });

  request.fail(function (jqXHR, textStatus, error) {
    console.log("Desila se greska: " + textStatus, error);
  });
});
