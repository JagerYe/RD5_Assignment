export class Employee {
    constructor(empID, empPassword) {
        this._empID = empID;
        this._empPassword = empPassword;
    }

    get empID() {
        return this._empID;
    }
    set empID(empID) {
        this._empID = empID;
    }

    get empPassword() {
        return this._empPassword;
    }
    set empPassword(empPassword) {
        this._empPassword = empPassword;
    }
}