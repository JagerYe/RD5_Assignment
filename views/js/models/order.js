export class Order {
    constructor(orderID, orderDate, attention = false, userId = "", total = 0) {
        this._orderID = orderID;
        this._orderDate = orderDate;
        this._attention = attention;
        this._userId = userId;
        this._total = total;
    }

    get orderID() {
        return this._orderID;
    }
    set orderID(orderID) {
        this._orderID = orderID;
    }

    get orderDate() {
        return this._orderDate;
    }
    set orderDate(orderDate) {
        this._orderDate = orderDate;
    }

    get attention() {
        return this._attention;
    }
    set attention(attention) {
        this._attention = attention;
    }

    get userId() {
        return this._userId;
    }
    set userId(userId) {
        this._userId = userId;
    }

    get total() {
        return this._total;
    }
    set total(total) {
        this._total = total;
    }
}