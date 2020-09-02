
function getMonthShow(month) {
    return `<div class="month" id="month${month}">
                <div>${month}</div>
                <div class="day" id="day${month}"></div>
            </div>`;
}

function getDayShow(day, deposit, withdrawal, currentAmount) {
    return `<div class="row">
                <div class="col">${day}</div>
                <div class="col">${deposit}</div>
                <div class="col">${withdrawal}</div>
                <div class="col">${currentAmount}</div>
            </div>`;
}


