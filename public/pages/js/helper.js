function formatNum(rawNum, prefix) {
    return prefix + rawNum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function setNumberPeriod(classname) {
    $("." + classname).keyup(function () {
        this.value = formatNum(this.value.replace(/[^\d]/g, ""), "");
    });
}

function setRupiahWithdot(classname) {
    $("." + classname).keyup(function () {
        var a = this.value.replace(/[^\d]/g, "");
        var a = +a;
        this.value = formatNum(a, "Rp. ");
    });
}
