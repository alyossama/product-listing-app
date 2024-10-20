<div class="container">
    <!-- header -->
    <div class="row justify-content-between align-items-center pt-5 pb-3 border-bottom">
        <div class="col-8">
            <div class="h1 text-warning">Product Add</div>
        </div>
        <div class="col-1">
            <button type="submit" form="product_form" id="submit" class="btn btn-outline-success">Save</button>
        </div>
        <div class="col-2">
            <a href="/" class="btn btn-outline-danger">Cancel</a>
        </div>
    </div>
    <!-- form -->
    <div class="row py-5">
        <form id="product_form" class="col-6" method="POST" action="/add-product">
            <!-- sku field -->
            <div class="form-row mb-3">
                <input class="form-control form-data" name="sku" id="sku" placeholder="SKU">
            </div>
            <!-- name field -->
            <div class="form-group mb-3">
                <input class="form-control form-data" name="name" id="name" placeholder="Name">
            </div>
            <!-- price field -->
            <div class="form-group mb-3">
                <input class="form-control form-data" name="price" id="price" placeholder="Price ($)">
            </div>
            <!-- product type field -->
            <div class="form-row mb-3">
                <div class="form-group col-8">
                    <select id="productType" name="type" class="form-control form-data">
                        <option selected value="">Type switcher</option>
                        <option value="dvd">DVD</option>
                        <option value="furniture">Furniture</option>
                        <option value="book">Book</option>
                    </select>
                </div>
            </div>
            <div id="specs"></div>
        </form>
    </div>
</div>