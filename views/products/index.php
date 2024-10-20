<div class="container">
    <!-- header -->
    <div class="row justify-content-between align-items-center pt-5 pb-3 border-bottom">
        <div class="col-8">
            <div class="h1">Product List</div>
        </div>
        <div class="col-1">
            <a
                href="/add-product"
                class="btn btn-outline-success">
                ADD
            </a>
        </div>
        <div class="col-2">
            <button
                type="submit"
                name="delete-multi-prod"
                form="delete-product"
                class="btn btn-outline-danger <?= !$products ? 'disabled':'' ?>"
                id="delete-product-btn">
                MASS DELETE
            </button>
        </div>
    </div>
    <!-- products -->
    <form id="delete-product" method="POST" action="/">
        <div class="row py-5">
            <?php
            if ($products) {
                foreach ($products as $product) {
            ?>
                    <div class="col-3 product my-3">
                        <div class="px-1 product border border-dark rounded">
                            <div class="container">
                                <div class="row py-3 px-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input delete-checkbox"
                                            type="checkbox"
                                            role="switch"
                                            name="product-delete[]"
                                            value="<?= $product['id'] ?>">
                                    </div>
                                </div>
                                <div class="row fw-bolder justify-content-center text-center mb-3">
                                    <div class="col-6">
                                        <p class="m-0"><?= $product['sku'] ?></p>
                                    </div>
                                </div>
                                <div class="row fw-bolder justify-content-center text-center mb-3">
                                    <div class="col-6">
                                        <p class="m-0"><?= $product['name'] ?></p>
                                    </div>
                                </div>
                                <div class="row fw-bolder justify-content-center text-center mb-3">
                                    <div class="col-6">
                                        <p class="m-0"><?= $product['price'] ?></p>
                                    </div>
                                </div>
                                <div class="row fw-bolder justify-content-center text-center mb-3">
                                    <div class="col-6">
                                        <p class="m-0"> <?= $product['specs'] ?> </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="col-12 text-center">
                    <p class="h1 text-muted">No Items to Show!</p>
                </div>
            <?php
            }
            ?>
        </div>
    </form>
</div>