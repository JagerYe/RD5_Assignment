function showIndex(name, balance) {
    return `<h1>您好！ ${name}</h1>
            <p>目前餘額：${balance}</p>
            <div id="featuresShow"></div>`;
}

function showMenu() {
    return `<ul class="navbar-nav mr-auto list">
                <li class="nav-item active">
                    <button type="button" class="btn btn-primary btn-lg btn-block">存款</button>
                </li>
                <li class="nav-item active">
                    <button type="button" class="btn btn-primary btn-lg btn-block">提款</button>
                </li>
                <li class="nav-item active">
                    <button type="button" class="btn btn-primary btn-lg btn-block">查詢明細</button>
                </li>
            </ul>`;
}

function showDepositAndWithdrawal() {
    return `<h2>請輸入存入金額</h2>
            <div><input id="input" type="number" min="0" value="0"></div><br>
            <div><button id="btnSub" type="button" class="btn btn-primary btn-lg btn-block">存入</button></div>`;
}

function showUnlogin() {
    return `<h1>您好！</h1>
            <h3>請進行下列動作</h3>
            <div>
                <ul class="navbar-nav mr-auto list">
                    <li class="nav-item active">
                        <a href="login.html" class="btn btn-primary btn-lg btn-block">登入</a>
                    </li>
                    <li class="nav-item active">
                        <a href="registered.html" class="btn btn-primary btn-lg btn-block">註冊</a>
                    </li>
                </ul>
            </div>`;
}