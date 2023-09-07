var customers = [];
var index = new Number(0);
var total = 0;
var size = new Number(3);
var totalpages = 0;
var pageno = new Number(1);
size = 8;

var messageBox = document.getElementById("message");
var messagepanel = document.getElementById("msgpanel");
var messagetitle = document.getElementById("msgtitle");
var message = document.getElementById("msg");
var id = "";
var deleteid="";

async function onloadCustomers() {
    var table = document.getElementById("table");
    onclearTable(table);
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/kaynikeStudio/system/customers", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            customers = data;
            onPageniation(customers, table);
        }
    };
}
function onPageniation(data, table) {
    total = data.length;
    totalpages = Math.ceil(total / size);
    pageno = new Number(1);
    var index = new Number(0);
    index = (pageno == "1" ? index : (pageno - 1) * size);
    for (var i = 0; i < data.length; i++) {
        var row = table.insertRow(table.length);
        var id = row.insertCell(0)
        var custname = row.insertCell(1);
        var address = row.insertCell(2);
        var emailaddress = row.insertCell(3);
        var phoneno = row.insertCell(4);
        var action = row.insertCell(5);
        id.innerHTML = i + 1;
        custname.innerHTML = customers[i]["customername"];
        address.innerHTML = customers[i]["address"];
        emailaddress.innerHTML = customers[i]["emailaddress"].toLowerCase();
        phoneno.innerHTML = customers[i]["phoneno"];
        action.innerHTML = '<button class="w3-bar-item w3-button  w3-black" onclick="onEditCustomer(this)">Edit</button><button onclick="onDeleteCustomer(this)" class="w3-bar-item w3-button w3-red">Delete</button>';
    }
    onDisplayTable(index);

}
async function onDisplayTable(index) {
    var table = document.getElementById('table');
    total = table.rows.length;//inludes the header;
    totalpages = Math.ceil(total / size);
    count = 1;
    tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        tr[i].style.display = "none"
        if (i == index + 1) {
            if (count <= size) {
                tr[i].style.display = "";
            }
            count++;
            index++;
        }
    }
}
function onclearTable(table) {
    tr = table.getElementsByTagName("tr");
    while (table.rows.length != 1) {
        for (var i = 1; i < table.rows.length; i++) {
            table.deleteRow(i);
        }
    }
}
async function onNextPage() {
    var table = document.getElementById("table");
    total = customers.length;
    totalpages = Math.ceil(total / size);
    pageno = pageno < totalpages ? pageno + 1 : pageno;
    var index = new Number(0);
    index = (pageno == "1" ? index : (pageno - 1) * size);
    onDisplayTable(index, table);
}
async function onPreviousPage() {
    var table = document.getElementById("table");
    total = customers.length;
    totalpages = Math.ceil(total / size);
    pageno = (pageno - 1) < 1 ? pageno : pageno - 1;
    var index = new Number(0);
    index = (pageno == "1" ? index : (pageno - 1) * size);
    onDisplayTable(index, table);
}
function onfiltervalue() {
    var input, filter, table, tr, td, td1, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        td1 = tr[i].getElementsByTagName("td")[1];
        if (td || td1) {
            txtValue1 = td1.textContent || td1.innerText;
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1 || txtValue1.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
////////onsave Customer///////
function onSaveCustomer() {
    var emailaddress = document.getElementById("emailaddress").value;
    var address = document.getElementById("address").value;
    var name = document.getElementById("name").value;
    var phoneno = document.getElementById("phoneno").value;
    var btn = document.getElementById('btn');
    btn.innerHTML = "Loading";
    btn.disabled = true;
    var formdata = 'emailaddress=' + emailaddress + '& address=' + address +
        '&customername=' + name + '&phoneno=' + phoneno + '';
    console.log(formdata);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/new/customer");


    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            btn.innerHTML = "New Customer";
            btn.disabled = false;
            document.getElementById('customerform').style.display = 'none';
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-green";
            messagetitle.innerHTML = "Success";
            message.innerHTML = feedback.message;

        } else {
            btn.innerHTML = "New Customer";
            btn.disabled = false;
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-red";
            messagetitle.innerHTML = "Failed !";
            message.innerHTML = xhr.responseText;
        }
    };
    xhr.send(formdata);
    onloadCustomers();
}
//////onDit button clicked
async function onEditCustomer(row) {
    var i = row.parentNode.parentNode.rowIndex;
    var table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
        txtValue = td.textContent || td.innerText;
        onloadData(txtValue);
    }
}
async function onloadData(text) {
    document.getElementById('customerform').style.display = 'block';
    var btn = document.getElementById('btn');
    var edit = document.getElementById('btn2');
    btn.style.display = 'none';

    edit.style.display = 'block';

    var query = '?id=' + customers[text-1].id + '';
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/kaynikeStudio/system/customer" + query);
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            var obj = data[0];
            id = obj.id;
            document.getElementById("name").value = obj.customername;
            document.getElementById("address").value = obj.address;
            document.getElementById("emailaddress").value = obj.emailaddress;
            document.getElementById("phoneno").value = obj.phoneno;
            if (edit.addEventListener) {     // For all major browsers, except IE 8 and earlier
                edit.addEventListener("click", onUpdateCustomer);
            } else if (x.attachEvent) {   // For IE 8 and earlier versions
                edit.attachEvent("onclick", onUpdateCustomer);
            }
            // edit.onclick= onUpdateCustomer();

        }
    };
    xhttp.send(query);
}
function onUpdateCustomer() {
    var btn = document.getElementById('btn2');

    var phoneno = document.getElementById("phoneno").value;
    var address = document.getElementById("address").value;
    var emailaddress = document.getElementById("emailaddress").value;
    var customername = document.getElementById("name").value;
    var formdata = 'customername=' + customername + '& emailaddress=' + emailaddress + '&address=' + address
        + '&phoneno=' + phoneno + '&id=' + id + '';
    console.log(formdata);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/edit/customer");
    btn.innerHTML = "Loading";
    btn.disabled = true;

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            document.getElementById('customerform').style.display = 'none';

            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-green";
            messagetitle.innerHTML = "Success";
            message.innerHTML = feedback.message;


        } else {
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-red";
            messagetitle.innerHTML = "Failed !";
            message.innerHTML = xhr.responseText;

        }
    };
    xhr.send(formdata);
    onloadCustomers();
}

function onclearForm() {
    document.getElementById("emailaddress").value = "";
    document.getElementById("phoneno").value = "";
    document.getElementById("address").value = "";
    document.getElementById("name").value = "";
    document.getElementById('btn2').style.display = "none";

    var btn = document.getElementById('btn');
    btn.style.display = "block";
    btn.innerHTML = " New Customer ";
    btn.disabled = false;
}
onloadCustomers();

async function onDeleteCustomer(row) {
    var i = row.parentNode.parentNode.rowIndex;
    var table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
        txtValue = td.textContent || td.innerText;
        onDeleteAll(txtValue);
    }
}
function onDeleteAll(txt) {
    deleteid = customers[txt-1].id;
    document.getElementById('deleteForm').style.display = 'block';
    var btnyes = document.getElementById('Yes');
    document.getElementById('delmsg').innerHTML="Are you sure you want to Delete?";
    if (btnyes.addEventListener) {     // For all major browsers, except IE 8 and earlier
        btnyes.addEventListener("click", deleteCustomer);
    } else if (x.attachEvent) {   // For IE 8 and earlier versions
        btnyes.attachEvent("onclick", deleteCustomer);
    }
}
function deleteCustomer() {
    var formdata = 'id=' + deleteid ;
    console.log(formdata);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/delete/customer/id");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            document.getElementById('deleteForm').style.display = 'none';
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-green";
            messagetitle.innerHTML = "Success Deleted";
            message.innerHTML = feedback.message;
        } else {
            document.getElementById('deleteForm').style.display = 'none';

            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-red";
            messagetitle.innerHTML = "Failed To Deleted!";
            message.innerHTML = xhr.responseText;
        }
    };
    xhr.send(formdata);
onloadCustomers();
}
