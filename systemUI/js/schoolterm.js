var terms = [];
var index = new Number(0);
var total = 0;
var size = new Number(3);
var totalpages = 0;
var pageno = new Number(1);
size = 4;

var messageBox = document.getElementById("message");
var messagepanel = document.getElementById("msgpanel");
var messagetitle = document.getElementById("msgtitle");
var message = document.getElementById("msg");
var id = "";


async function onloadSchoolTerms() {
    var table = document.getElementById("table");
    onclearTable(table);
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost:3000/terms", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            terms = data;
            onPageniation(terms, table);
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
        var startdate = row.insertCell(1);
        var enddate = row.insertCell(2);
        var status = row.insertCell(3);
        // var stuDob = row.insertCell(4);
        var action = row.insertCell(4);
        id.innerHTML = terms[i]["id"];
        startdate.innerHTML = terms[i]["term_start"];
        enddate.innerHTML = terms[i]["term_end"];
        status.innerHTML = terms[i]["term_status"];
        action.innerHTML = '<button class="w3-bar-item w3-button  w3-black" onclick="onEditTerm(this)">Edit</button><button class="w3-bar-item w3-button w3-red">Delete</button>';
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
    total = terms.length;
    totalpages = Math.ceil(total / size);
    pageno = pageno < totalpages ? pageno + 1 : pageno;
    var index = new Number(0);
    index = (pageno == "1" ? index : (pageno - 1) * size);
    onDisplayTable(index, table);
}
async function onPreviousPage() {
    var table = document.getElementById("table");
    total = terms.length;
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
        td = tr[i].getElementsByTagName("td")[1];
        td1 = tr[i].getElementsByTagName("td")[2];
        td2 = tr[i].getElementsByTagName("td")[3];
        if (td || td1 || td2) {
            txtValue2 = td2.textContent || td2.innerText;

            txtValue1 = td1.textContent || td1.innerText;
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1
                ||
                txtValue1.toUpperCase().indexOf(filter) > -1
                ||
                txtValue2.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
onloadSchoolTerms();
///////on Add Staff///////
function onSaveSchoolTerm() {
    console.log("saving ....")
    var term_start = document.getElementById("startdate").value;
    var term_end = document.getElementById("enddate").value;
    var term_status = document.getElementById("status").value == "" ? "InActive" : document.getElementById("status").value;

    var btn = document.getElementById('btn');
    btn.innerHTML = "Loading";
    btn.disabled = true;
    var formdata = 'term_start=' + term_start + '& term_end=' + term_end + '&term_status=' + term_status;
    console.log(formdata);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:3000/new/term");


    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            btn.innerHTML = "Create New  School Term";
            btn.disabled = false;
            document.getElementById('termfom').style.display = 'none';
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-green";
            messagetitle.innerHTML = "Success";
            message.innerHTML = feedback.message;


        } else {
            btn.innerHTML = "Create New  School Term";
            btn.disabled = false;
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-red";
            messagetitle.innerHTML = "Failed !";
            message.innerHTML = xhr.responseText;
        }
    };
    xhr.send(formdata);
    onloadSchoolTerms();
}

async function onEditTerm(row) {
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
    document.getElementById('termfom').style.display = 'block';
    console.warn(text);
    var btn = document.getElementById('btn');
    var edit = document.getElementById('btn2');
    btn.style.display = 'none';

    edit.style.display = 'block';

    var query = '?id=' + text + '';
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost:3000/term" + query);
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var data = JSON.parse(this.responseText);
            var obj = data[0];
            id = obj.id;
            document.getElementById("startdate").value = obj.term_start;
            document.getElementById("enddate").value = obj.term_end;
            document.getElementById("status").value = obj.term_status;

            if (edit.addEventListener) {     // For all major browsers, except IE 8 and earlier
                edit.addEventListener("click", onUpdateSchoolTerm);
            } else if (x.attachEvent) {   // For IE 8 and earlier versions
                edit.attachEvent("onclick", onUpdateSchoolTerm);
            }
            // edit.onclick= onUpdateSchoolTerm();

        }
    };
    xhttp.send(query);
}
function onUpdateSchoolTerm() {
    console.log("clicked" + id);
    var btn = document.getElementById('btn2');

    var term_start = document.getElementById("startdate").value;
    var term_end = document.getElementById("enddate").value;
    var term_status = document.getElementById("status").value == "" ? "InActive" : document.getElementById("status").value;

    var btn = document.getElementById('btn');
    btn.innerHTML = "Loading";
    btn.disabled = true;
    var formdata = 'term_start=' + term_start + '& term_end=' + term_end + '&term_status=' + term_status + '&id=' + id;
    console.log(formdata);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:3000/edit/term");
    btn.innerHTML = "Loading";
    btn.disabled = true;

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            document.getElementById('termfom').style.display = 'none';

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
    onloadSchoolTerms();
}

function onclearForm() {
    document.getElementById('btn').style.display = "none";
    document.getElementById("startdate").value = "";
    document.getElementById("enddate").value = "";
    document.getElementById("status").value = "";
    var btn = document.getElementById('btn');
    btn.style.display = "block";
    btn.innerHTML = "Create New School Term ";
    btn.disabled = false;

}
