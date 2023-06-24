<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>


<div class="card container" style="margin: 20px; width: 38rem; border-width: medium; border-color: #0f0f0f">
    <div class="row justify-content-around align-items-center">
        <div class="col-md-3">
            <img src="/admin/shona.png" alt="" class="img-fluid">
        </div>
        <div class="col-md-3">
            <span class="" style="font-weight: bold; font-size: 20px">ID: <?=$order->id?></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form class="row">
                <div class="col-md-7">
                    <label for="inputEmail4" class="form-label">Buyurtmachi:</label>
                    <input type="text" disabled value="<?=$order->client_fullname?>" class="form-control" id="inputEmail4">
                </div>
                <div class="col-md-5">
                    <label for="inputPassword4" class="form-label">Telefon raqami</label>
                    <input type="text" disabled value="<?=$order->client_phone?>" class="form-control" id="inputPassword4">
                </div>
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Manzili</label>
                    <textarea disabled  class="form-control" rows="5" id="inputAddress" placeholder="1234 Main St"><?=$order->client_address?></textarea>
                </div>

            </form>
        </div>
    </div>
    <div class="mt-3 row">
        <div class="col-md-12">
            <div class="container card mb-2" style="border-color: #0f0f0f"">
                <div class="row">
                    <p>Buyurtma</p>
                </div>
                <table >
                    <tbody>
                    <?php foreach ($order->salesProducts as $product): ?>
                        <tr>
                            <td>
                                <input type="text" disabled value="<?=$product->product->name?>" class="form-control" id="inputPassword4">
                                <div class="row">
                                    <div class="col-md-7">
                                        <p>IKPU: <?=$product->product->ikpu?></p>
                                    </div>
                                    <div class="col-md-5">
                                        <p>PACKAGE CODE: <?=$product->product->package?></p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="row mb-2">
                    <div class="col-md-7">
                        <label for="inputPassword4" class="form-label">Kommentariya</label>
                        <textarea type="text" disabled class="form-control" id="inputPassword4"><?=$order->name?></textarea>
                    </div>
                    <div class="col-md-5">
                        <label for="inputPassword4" class="form-label">To'lov turi</label>
                        <input type="text" disabled class="form-control" value="<?=$order->paymentType->name?>" id="inputPassword4">
                    </div>
                </div>

                <p>Operator: <?=$order->operatorFullname?></p>
            <p>Aloqa markazi: +998 55 500 74 00</p>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>