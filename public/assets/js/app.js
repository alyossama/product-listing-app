$(document).ready(function () {
  // Add Product Form | Dynamic specifications fields according to the product type
  const fieldTemplates = {
    dvd: `
    <div class="form-group" id="dvd">
        <input class="form-control form-data" name="size" id="size" placeholder="Size (MB)">
        <p class="text-muted">Please provide size in MB</p>
    </div>
`,
    book: `
    <div class="form-group" id="book">
        <input class="form-control form-data" name="weight" id="weight" placeholder="weight (KG)">
        <p class="text-muted">Please provide weight in KG</p>
    </div>
`,
    furniture: `
    <div class="form-group" id="furniture">
        <input class="form-control form-data" name="length" id="length" placeholder="Length (CM)">
        <input class="form-control form-data my-2" name="width" id="width" placeholder="Width (CM)">
        <input class="form-control form-data my-2" name="height" id="height" placeholder="Height (CM)">
        <p class="text-muted">Please provide dimensions in LxWxH Format</p>
    </div>
`,
  };

  $("#productType").change(function () {
    var selectedType = $(this).val();
    displayFields(selectedType);
  });

  function displayFields(selectedType) {
    $("#specs").empty();

    if (selectedType && fieldTemplates[selectedType]) {
      $("#specs").append(fieldTemplates[selectedType]);
    }
  }

  // Add Product Form | AJAX Request for validation errors
  $("#product_form").on("submit", function (event) {
    event.preventDefault();

    $.ajax({
      url: "/add-product",
      type: "POST",
      data: {
        sku: $("#sku").val(),
        name: $("#name").val(),
        price: $("#price").val(),
        type: $("#productType").val(),
        size: $("#size").val(),
        weight: $("#weight").val(),
        length: $("#length").val(),
        width: $("#width").val(),
        height: $("#height").val(),
      },
      dataType: "json",
      success: function (response) {
        if (response.errors) {
          displayErrors(response.errors);
        } else {
          window.location.href = "/";
        }
      },
    });
  });

  function displayErrors(errors) {
    $(".error").remove();

    for (var field in errors) {
      if (errors.hasOwnProperty(field)) {
        var errorMessage = errors[field];
        if (field == "type") {
          field = "productType";
        }

        $("#" + field).after(
          '<div class="error text-danger">*' + errorMessage + "</div>"
        );
      }
    }
  }
});
