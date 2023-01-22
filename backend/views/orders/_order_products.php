<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Ombor nomi</th>
            <th scope="col">Mahsulot nomi</th>
            <th scope="col">Soni</th>
            <th scope="col">Olingan narx</th>
            <th scope="col">Mijozga sotilgan narx</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($model->salesProducts as $item) : ?>
            <tr>
                <td><?=$item->partnerShop->name??""?></td>
                <td><?=$item->product->name??""?></td>
                <td><?=$item->count?></td>
                <td><?=$item->partner_shop_price?></td>
                <td><?=$item->sold_price?></td>
<!--                <td>--><?php //print_r($item);?><!--</td>-->
<!--                <td>@mdo</td>-->
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>