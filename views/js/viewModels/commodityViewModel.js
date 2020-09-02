export class CommodityViewModel {
    // constructor() {
    //     tool = new CommodityViewModel();
    // }

    static getMenuView(id, name, price) {
        return `<div class="col-md-4">
                    <a href="/PID_Assignment/views/pageFront/commodity.html?commodityID=${id}">
                        <div class="card mb-4 shadow-sm">
                            <img src="/PID_Assignment/views/img/gravatar.jpg">
                            <div class="card-body">
                                <h2>${name}</h2>
                                <p class="card-text">價格：${price}</p>
                            </div>
                        </div>
                    </a>
                </div>`;
    }

    static getOneCommodityView(name, text, price, quantity) {
        return `
            <img src="/PID_Assignment/views/img/gravatar.jpg">
            <h1 class="author-title">${name}</h1>
            <h5>${text}</h5>
            <h2 class="author-bio">${price}</h2>
            <h3>
                數量<input id="commodityQuantity" name="commodityQuantity" 
                    type="number" min="0" max="${quantity}" value="1">
            </h3>
            <button id="addInCart" name="addInCart" type="button" class="btn btn-primary">加入購物車</button>
        `;
    }

    static getShoppingCartView(name, price, commodityQuantity, buyQuantity, id) {
        return `<li class="row">
                    <div class="col-3"><img src="/PID_Assignment/views/img/gravatar.jpg"></div>
                    <div class="col-3">${name}</div>
                    <div class="col-3">${price}</div>
                    <div class="col-2">
                        <input class="commodityQuantity" id="commodityQuantity${id}" name="commodityQuantity" 
                            type="number" min="0" max="${commodityQuantity}" value="${buyQuantity}">
                    </div>
                    <div class="col-1">
                        <button type="button" id="commodityDelete${id}" class="commodityDelete btn">刪除</button>
                    </div>
                </li>`;
    }

    //id, name, price, text, status為物件狀態
    //isAdd為判斷是否為新增模式
    static getManagerView(id, name, price, quantity, text, status, isAdd) {
        // SELECTED
        return `
        <li>
            <div class="row titel">
                <div class="col-3"><strong>商品圖片</strong></div>
                <div class="col-3"><strong>名稱</strong></div>
                <div class="col-3"><strong>單價</strong></div>
                <div class="col-2"><strong>數量</strong></div>
                <div class="col-1"><strong>狀態</strong></div>
            </div>
            <div class="row">
                <div class="col-3">
                    <img src="/PID_Assignment/views/img/gravatar.jpg"><br>
                </div>
                <div class="col-3"><input id="commodityName${id}" name="commodityName${id}" type="text"
                value="${name}"></div>
                <div class="col-3"><input id="commodityPrice${id}" name="commodityPrice${id}" type="number" value="${price}"></div>
                <div class="col-2"><input id="commodityQuantity${id}" name="commodityQuantity${id}" type="number" min="0" value="${quantity}"></div>
                <div class="col-1">
                    <select id="select${id}" name="select${id}" class="custom-select">
                        ${CommodityViewModel.getStatus(status)}
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    更新圖片
                    <input type="file" name="commodityImg${id}" id="commodityImg${id}">
                </div>
                <div class="col-5">
                    <textarea id="textarea${id}" name="textarea${id}" cols="40" rows="5" class="form-control">
                        ${text}
                    </textarea>
                </div>
                <div class="col-2">${CommodityViewModel.getBtn(isAdd, id)}</div>
            </div><hr><hr>
        </li>
        `;
    }

    static getStatus(status) {
        switch (status) {
            case "open":
                return `<option value="open" SELECTED>上架</option>
                        <option value="close">下架</option>
                        <option value="delete">刪除</option>`;
            case "close":
                return `<option value="open">上架</option>
                        <option value="close" SELECTED>下架</option>
                        <option value="delete">刪除</option>`;
            case "delete":
                return `<option value="open">上架</option>
                        <option value="close">下架</option>
                        <option value="delete" SELECTED>刪除</option>`;
        }
        return `<option value="open">上架</option>
                <option value="close">下架</option>
                <option value="delete">刪除</option>`;

    }

    static getBtn(isAdd, id) {
        if (isAdd) {
            return `<button class="btn btn-success" type="button" id="btnAdd${id}">新增商品</button>`;
        }
        return `<button class="btn btn-success" type="button" id="btnUpdate${id}">更新商品內容</button>`;
    }
}
