export class ShoppingCart {
    constructor(commodityID, buyQuantity) {
        this._commodityID = commodityID;
        this._buyQuantity = buyQuantity;
    }

    get commodityID() {
        return this._commodityID;
    }
    set commodityID(commodityID) {
        this._commodityID = commodityID;
    }

    get buyQuantity() {
        return this._buyQuantity;
    }
    set buyQuantity(buyQuantity) {
        this._buyQuantity = buyQuantity;
    }
}