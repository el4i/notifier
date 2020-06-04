<b>Привет! Отправлю Вам список ваших заказанных товаров.</b>
</br>
<div class="table-responsive">
    <table style="width: 50%; border: 1px solid #ddd; border-collapse: collapse;">
        <thead>
        <tr style="background: #f9f9f9;">
            <th style="padding: 5px; border: 1px solid #ddd;">Наименование</th>
            <th style="padding: 4px; border: 1px solid #ddd;">Цена</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;"><?= $order['product']?></td>
                <td style="padding: 4px; border: 1px solid #ddd;"><?= $order['price']?></td>
            </tr>
        </tbody>
    </table>
</div>