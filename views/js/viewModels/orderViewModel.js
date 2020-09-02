export class OrderViewModel {
    static getOrderView(id, date, total) {
        return `<li class="aOrder">
                    <div class="row" id="aOrder${id}">
                        <div class="col-4" id="oderID">${id}</div>
                        <div class="col-4">${date}</div>
                        <div class="col-2 total">${total}</div>
                        <div class="col-2"><button class="btn" type="button">顯示明細</button></div>
                    </div>
                    <ul id="orderDetails${id}">
                    </ul>
                </li>`;
    }

    static getDetailsView(name, price, quantity) {
        return `<li class="row">
                    <div class="col-3"><img src="/PID_Assignment/views/img/gravatar.jpg"></div>
                    <div class="col-3">${name}</div>
                    <div class="col-3">${price}</div>
                    <div class="col-3">${quantity}</div>
                </li><br>`;
    }
}
