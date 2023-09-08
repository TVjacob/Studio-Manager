var students = [];
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

async function onloadStudents() {
    var table = document.getElementById("table");
    onclearTable(table);
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/students", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            students = data;
            onPageniation(students, table);
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
        var stucode = row.insertCell(1);
        var stuname = row.insertCell(2);
        var stuclass = row.insertCell(3);
        var stuDob = row.insertCell(4);
        var action = row.insertCell(5);
        id.innerHTML = i + 1;
        stucode.innerHTML = students[i]["studentCode"];
        stuname.innerHTML = students[i]["name"].toUpperCase();
        stuDob.innerHTML = students[i]["dob"].toUpperCase();
        stuclass.innerHTML = students[i]["sclass"];
        action.innerHTML = '<button class="w3-bar-item w3-button  w3-black" onclick="onEditStudent(this)">Edit</button><button class="w3-bar-item w3-button w3-red">Delete</button>';
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
    total = students.length;
    totalpages = Math.ceil(total / size);
    pageno = pageno < totalpages ? pageno + 1 : pageno;
    var index = new Number(0);
    index = (pageno == "1" ? index : (pageno - 1) * size);
    onDisplayTable(index, table);
}
async function onPreviousPage() {
    var table = document.getElementById("table");
    total = students.length;
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
////////onsave Student///////
function onSaveStudent() {
    console.log("saving ....")
    var address = document.getElementById("address").value;
    var parents = document.getElementById("parents").value;
    var phoneno = document.getElementById("phoneno").value;
    var dob = document.getElementById("dob").value;
    var name = document.getElementById("stuname").value;
    var sclass = document.getElementById("sclass").value;
    var studentCode = document.getElementById("studentCode").innerText;
    var btn = document.getElementById('btn');
    btn.innerHTML = "Loading";
    btn.disabled = true;
    var formdata = 'name=' + name + '& studentCode=' + studentCode + '&sclass=' + sclass + '&dob=' + dob + '&phoneno=' + phoneno + '&parents=' + parents + '&address=' + address + '';
    console.log(formdata);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/KanyikeStudio/system/new/student");


    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            btn.innerHTML = "Save Student";
            btn.disabled = false;
            document.getElementById('studentform').style.display = 'none';
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-green";
            messagetitle.innerHTML = "Success";
            message.innerHTML = feedback.message;


        } else {
            btn.innerHTML = "Save Student";
            btn.disabled = false;
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-red";
            messagetitle.innerHTML = "Failed !";
            message.innerHTML = xhr.responseText;
        }
    };
    xhr.send(formdata);
    onloadStudents();
}
//ongenerate student number
function ongeneratestudentCode() {
    var table = document.getElementById("table");
    var number = table.rows.length;
    document.getElementById("studentCode").innerHTML = "jjs" + number;

}
//////onDit button clicked
async function onEditStudent(row) {
    var i = row.parentNode.parentNode.rowIndex;
    var table = document.getElementById("table");
    tr = table.getElementsByTagName("tr");
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
        txtValue = td.textContent || td.innerText;
        onloadData(txtValue);
    }
}
async function onloadData(text) {
    document.getElementById('studentform').style.display = 'block';
    console.warn(text);
    var btn = document.getElementById('btn');
    var edit = document.getElementById('btn2');
    btn.style.display = 'none';

    edit.style.display = 'block';

    var query = '?studentCode=' + text + '';
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/KanyikeStudio/system/student" + query);
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var data = JSON.parse(this.responseText);
            var obj = data[0];
            id = obj.studentCode;
            document.getElementById("address").value = obj.address;
            document.getElementById("parents").value = obj.parents;
            document.getElementById("phoneno").value = obj.phoneno;
            document.getElementById("dob").value = obj.dob;
            document.getElementById("stuname").value = obj.name;
            document.getElementById("sclass").value = obj.sclass;
            document.getElementById("studentCode").innerText = text;
            if (edit.addEventListener) {     // For all major browsers, except IE 8 and earlier
                edit.addEventListener("click", onUpdateStudent);
            } else if (x.attachEvent) {   // For IE 8 and earlier versions
                edit.attachEvent("onclick", onUpdateStudent);
            }
            // edit.onclick= onUpdateStudent();

        }
    };
    xhttp.send(query);
}
function onUpdateStudent() {
    console.log("clicked" + id);
    var btn = document.getElementById('btn2');

    var address = document.getElementById("address").value;
    var parents = document.getElementById("parents").value;
    var phoneno = document.getElementById("phoneno").value;
    var dob = document.getElementById("dob").value;
    var name = document.getElementById("stuname").value;
    var sclass = document.getElementById("sclass").value;
    var studentCode = document.getElementById("studentCode").innerText;
    var formdata = 'name=' + name + '& studentCode=' + studentCode + '&sclass=' + sclass + '&dob=' + dob + '&phoneno=' + phoneno + '&parents=' + parents + '&address=' + address + '';
    console.log(formdata);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/KanyikeStudio/system/edit/student");
    btn.innerHTML = "Loading";
    btn.disabled = true;

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            document.getElementById('studentform').style.display = 'none';

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
    onloadStudents();
}

function onclearForm() {
    document.getElementById("address").value = "";
    document.getElementById("parents").value = "";
    document.getElementById("phoneno").value = "";
    document.getElementById("dob").value = "";
    document.getElementById("stuname").value = "";
    document.getElementById("sclass").value = "";
    document.getElementById("studentCode").innerText = "";;
    document.getElementById('btn2').style.display="none";

    var btn = document.getElementById('btn');
    btn.style.display="block";
    btn.innerHTML = " Save Student ";
    btn.disabled = false;
}















onloadStudents();