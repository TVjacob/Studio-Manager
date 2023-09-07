var products = [];
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


async function onloadProducts() {
    var table = document.getElementById("table");
    onclearTable(table);
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/kaynikeStudio/system/products", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            products = data;
            onPageniation(products, table);
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
        var name = row.insertCell(1);
        var rate = row.insertCell(2);
        var amount = row.insertCell(3);
        var units = row.insertCell(4);
        var action = row.insertCell(5);
        id.innerHTML = products[i].id;
        name.innerHTML = products[i]["productname"];
        rate.innerHTML = products[i]["rate"].toUpperCase();
        amount.innerHTML = products[i]["amount"].toUpperCase();
        units.innerHTML = products[i]["units"];
        action.innerHTML = '<button class="w3-bar-item w3-button  w3-black" onclick="onEditProduct(this)">Edit</button><button onclick="onDeleteProduct(this)" class="w3-bar-item w3-button w3-red">Delete</button>';
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
    total = products.length;
    totalpages = Math.ceil(total / size);
    pageno = pageno < totalpages ? pageno + 1 : pageno;
    var index = new Number(0);
    index = (pageno == "1" ? index : (pageno - 1) * size);
    onDisplayTable(index, table);
}
async function onPreviousPage() {
    var table = document.getElementById("table");
    total = products.length;
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
////////onsave Product///////
function onSaveProduct() {
    console.log("saving ....");
    var rate = document.getElementById("rate").value;
    var amount = document.getElementById("amount").value;
    var name = document.getElementById("name").value;
    var units = document.getElementById("units").value;
    var btn = document.getElementById('btn');
    btn.innerHTML = "Loading";
    btn.disabled = true;
    var formdata = 'productname=' + name + '& units=' + units + '&amount=' + amount + '&rate=' + rate + '';
    console.log(formdata);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/new/product");


    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            btn.innerHTML = "New Product";
            btn.disabled = false;
            document.getElementById('productform').style.display = 'none';
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-green";
            messagetitle.innerHTML = "Success";
            message.innerHTML = feedback.message;


        } else {
            btn.innerHTML = "New Product";
            btn.disabled = false;
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-red";
            messagetitle.innerHTML = "Failed !";
            message.innerHTML = xhr.responseText;
        }
    };
    xhr.send(formdata);
    onloadProducts();
}
//////onDit button clicked
async function onEditProduct(row) {
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
    document.getElementById('productform').style.display = 'block';
    console.warn(text);
    var btn = document.getElementById('btn');
    var edit = document.getElementById('btn2');
    btn.style.display = 'none';

    edit.style.display = 'block';

    var query = '?id=' + text + '';
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/kaynikeStudio/system/product" + query);
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var data = JSON.parse(this.responseText);
            var obj = data[0];
            id = obj.id;
            document.getElementById("units").value = obj.units;
            document.getElementById("amount").value = obj.amount;
            document.getElementById("name").value = obj.name;
            document.getElementById("rate").value = obj.rate;
            if (edit.addEventListener) {     // For all major browsers, except IE 8 and earlier
                edit.addEventListener("click", onUpdateProduct);
            } else if (x.attachEvent) {   // For IE 8 and earlier versions
                edit.attachEvent("onclick", onUpdateProduct);
            }
            // edit.onclick= onUpdateProduct();

        }
    };
    xhttp.send(query);
    
}
function onUpdateProduct() {
    console.log("clicked" + id);
    var btn = document.getElementById('btn2');

    var rate = document.getElementById("rate").value;
    var amount = document.getElementById("amount").value;
    var name = document.getElementById("name").value;
    var units = document.getElementById("units").value;
    var formdata = 'name=' + name + '& rate=' + rate + '&amount=' + amount 
    + '&units=' + units + '&id=' + id  + '';
    console.log(formdata);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/edit/product");
    btn.innerHTML = "Loading";
    btn.disabled = true;

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            document.getElementById('productform').style.display = 'none';

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
    onloadProducts();
}

function onclearForm() {
    document.getElementById("units").value = "hourly";
    document.getElementById("amount").value = 0;
    document.getElementById("rate").value = 0;
    document.getElementById("name").value = "";
    document.getElementById('btn2').style.display="none";

    var btn = document.getElementById('btn');
    btn.style.display="block";
    btn.innerHTML = " New Product ";
    btn.disabled = false;
}




onloadProducts();
async function onDeleteProduct(row) {
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
    deleteid = txt;
    document.getElementById('deleteForm').style.display = 'block';
    var btnyes = document.getElementById('Yes');
    document.getElementById('delmsg').innerHTML="Are you sure you want to Delete?";
    if (btnyes.addEventListener) {     // For all major browsers, except IE 8 and earlier
        btnyes.addEventListener("click", deleteProduct);
    } else if (x.attachEvent) {   // For IE 8 and earlier versions
        btnyes.attachEvent("onclick", deleteProduct);
    }
}
function deleteProduct() {
    var formdata = 'id=' + deleteid ;
    console.log(formdata);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/delete/product");
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
onloadProducts();
}











