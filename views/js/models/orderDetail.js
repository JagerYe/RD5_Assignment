export class OrderDetail {
    constructor(orderID, commodityNane, orderCommodityPrice, orderCommodityQuantity) {
        this._orderID = orderID;
        this._commodityNane = commodityNane;
        this._orderCommodityPrice = orderCommodityPrice;
        this._orderCommodityQuantity = orderCommodityQuantity;
    }

    get orderID() {
        return this._orderID;
    }
    set orderID(orderID) {
        this._orderID = orderID;
    }

    get commodityNane() {
        return this._commodityNane;
    }
    set commodityNane(commodityNane) {
        this._commodityNane = commodityNane;
    }

    get orderCommodityPrice() {
        return this._orderCommodityPrice;
    }
    set orderCommodityPrice(orderCommodityPrice) {
        this._orderCommodityPrice = orderCommodityPrice;
    }

    get orderCommodityQuantity() {
        return this._orderCommodityQuantity;
    }
    set orderCommodityQuantity(orderCommodityQuantity) {
        this._orderCommodityQuantity = orderCommodityQuantity;
    }
}