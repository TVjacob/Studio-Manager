var customers = [];
var bills = [];
var payments = [];
var balances = [];
var staffs = [];
var users = [];
var products = [];

onloadCustomers();
onloadpayments();
onloadStaffs();
onloadusers();
onloadservices();

async function onloadCustomers() {

    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/customers", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            customers.push(data);
            document.getElementById("customers").innerHTML = format(customers.length);
            onloadbills(customers);
        }
    };
}

async function onloadStaffs() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/staffs", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            staffs = data;
            document.getElementById("tolstaff").innerHTML = staffs.length;


        }
    };
}
async function onloadusers() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/users", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            users = users.concat(data);
            document.getElementById("totalUser").innerHTML = format(users.length);

        }
    };

}
async function onloadservices() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/products", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            products = products.concat(data);
            document.getElementById("totalservices").innerHTML = format(products.length);

        }
    };
}

async function onloadpayments() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/total/recipts", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            payments = payments.concat(data);
            document.getElementById("rev").innerHTML = format(payments[0].totalamount);

        }
    };

}
async function onloadbills(customerinfor) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/total/bills", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            bills = bills.concat(data);
            document.getElementById("totalbill").innerHTML = format(bills[0].totalamount);
            document.getElementById("bill").innerHTML = format(bills[0].totalamount);

            onloadbalances(bills, customerinfor);
        }
    };
}
async function onloadbalances(bill, customerinfor) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/total/balances", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            balances = balances.concat(data);
            var balance = balances[0].totalbill - balances[0].totalpayments;
            document.getElementById("bal").innerHTML = format(balance);
            ongenerateStatistics(bill, balances, customerinfor);
        }
    };
}
function ongenerateStatistics(billinfo, balanceinfo, customerinfor) {
    console.log(bills);
    console.log(balances);
    console.log(balances);
    var totalbills = bills[0].totalamount;
    var totalamount = balances[0].totalpayments;
    var totalbalance = totalbills - totalamount;
    var totalcustomers = customers.length;
    var customer = document.getElementById("cust");
    customer.style.width = Math.round(totalcustomers / 1000 * 100) + "%";
    customer.innerHTML = Math.round(totalcustomers / 1000 * 100) + "%" + "";
    var payment = document.getElementById("payments");
    payment.style.width = Math.round(totalamount / totalbills * 100) + "%";
    payment.innerHTML = Math.round(totalamount / totalbills * 100) + "%";
    var payment = document.getElementById("balances");
    payment.style.width = Math.round(totalbalance / totalbills * 100) + "%";
    payment.innerHTML = Math.round(totalbalance / totalbills * 100) + "%";
    ///////////tabale ////
    var totalcustomer = document.getElementById("totalcust");
    totalcustomer.innerHTML = Math.round(totalcustomers) + "";
    var totalbalance = document.getElementById("totalbal");
    totalbalance.innerHTML = format(Math.round(totalamount));
    var totalstaff = document.getElementById("totalstaff");
    totalstaff.innerHTML = Math.round(totalbalance / totalbills * 100) + "%";





}
function format(amt) {
    var patt1 = /[0-9.]/g;
    var value = amt.toString();
    var total = "";
    var numbers = value.match(patt1);
    var count = 0;
    for (var i = numbers.length - 1; i >= 0; i--) {
        if (count === 3) {
            numbers[i] = numbers[i] + ",";
            count = 0;
        }
        count++;
    }
    numbers.forEach(myFunction);

    function myFunction(item) {
        total += item;
        amt = total;
    }
    return amt;
}

