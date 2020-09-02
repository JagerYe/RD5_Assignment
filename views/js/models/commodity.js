export class Commodity {
    constructor(commodityID, commodityName="", commodityPrice=0, commodityQuantity=0, commodityStatus="close", commodityText="", commodityImage=null) {
        this._commodityID = commodityID;
        this._commodityName = commodityName;
        this._commodityPrice = commodityPrice;
        this._commodityQuantity = commodityQuantity;
        this._commodityStatus = commodityStatus;
        this._commodityText = commodityText;
        this._commodityImage = commodityImage;
    }

    get commodityID() {
        return this._commodityID;
    }
    set commodityID(commodityID) {
        this._commodityID = commodityID;
    }

    get commodityName() {
        return this._commodityName;
    }
    set commodityName(commodityName) {
        this._commodityName = commodityName;
    }

    get commodityPrice() {
        return this._commodityPrice;
    }
    set commodityPrice(commodityPrice) {
        this._commodityPrice = commodityPrice;
    }

    get commodityQuantity() {
        return this._commodityQuantity;
    }
    set commodityQuantity(commodityQuantity) {
        this._commodityQuantity = commodityQuantity;
    }

    get commodityStatus() {
        return this._commodityStatus;
    }
    set commodityStatus(commodityStatus) {
        this._commodityStatus = commodityStatus;
    }

    get commodityText() {
        return this._commodityText;
    }
    set commodityText(commodityText) {
        this._commodityText = commodityText;
    }

    get commodityImage() {
        return this._commodityImage;
    }
    set commodityImage(commodityImage) {
        this._commodityImage = commodityImage;
    }
}