var staffs = [];
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


async function onloadStaffs() {
    var table = document.getElementById("table");
    onclearTable(table);
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/kaynikeStudio/system/staffs", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            staffs = data;
            onPageniation(staffs, table);
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
        var role = row.insertCell(3);
        var stuDob = row.insertCell(4);
        var action = row.insertCell(5);
        id.innerHTML = i + 1;
        stucode.innerHTML = staffs[i]["staffCode"];
        stuname.innerHTML = staffs[i]["name"].toUpperCase();
        stuDob.innerHTML = staffs[i]["dob"].toUpperCase();
        role.innerHTML = staffs[i]["role"];
        action.innerHTML = '<button class="w3-bar-item w3-button  w3-black" onclick="onEditStudent(this)">Edit</button><button onclick="onDeleteStaff(this)" class="w3-bar-item w3-button w3-red">Delete</button>';
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
    total = staffs.length;
    totalpages = Math.ceil(total / size);
    pageno = pageno < totalpages ? pageno + 1 : pageno;
    var index = new Number(0);
    index = (pageno == "1" ? index : (pageno - 1) * size);
    onDisplayTable(index, table);
}
async function onPreviousPage() {
    var table = document.getElementById("table");
    total = staffs.length;
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
onloadStaffs();
///////on Add Staff///////
function onSaveStaff() {
    console.log("saving ....")
    var address = document.getElementById("address").value;
    var salary = document.getElementById("salary").value;
    var role = document.getElementById("role").value;
    var dob = document.getElementById("dob").value;
    var name = document.getElementById("staffname").value;
    var phoneno = document.getElementById("phoneno").value;
    var staffCode = document.getElementById("staffCode").innerText;
    var btn = document.getElementById('btn');
    btn.innerHTML = "Loading";
    btn.disabled = true;
    var formdata = 'name=' + name + '& staffCode=' + staffCode + '&role=' + role + '&dob=' + dob + '&phoneno=' + phoneno + '&salary=' + unFormat(salary) + '&address=' + address + '';
    console.log(formdata);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/new/staff");


    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            btn.innerHTML = "Save Staff";
            btn.disabled = false;
            document.getElementById('staffform').style.display = 'none';
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-green";
            messagetitle.innerHTML = "Success";
            message.innerHTML = feedback.message;


        } else {
            btn.innerHTML = "Save Staff";
            btn.disabled = false;
            messageBox.style.display = 'block';
            messagepanel.className = "w3-panel w3-red";
            messagetitle.innerHTML = "Failed !";
            message.innerHTML = xhr.responseText;
        }
    };
    xhr.send(formdata);
    onloadStaffs();
}
//ongenerate student number
function ongeneratestudentCode() {
    var table = document.getElementById("table");
    var number = table.rows.length;
    document.getElementById("staffCode").innerHTML = "staff" + number;
}

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
    document.getElementById('staffform').style.display = 'block';
    console.warn(text);
    var btn = document.getElementById('btn');
    var edit = document.getElementById('btn2');
    btn.style.display = 'none';

    edit.style.display = 'block';

    var query = '?staffCode=' + text + '';
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://localhost/kaynikeStudio/system/staff" + query);
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var data = JSON.parse(this.responseText);
            var obj = data[0];
            id = obj.staffCode;
            document.getElementById("address").value = obj.address;
            document.getElementById("salary").value = obj.salary;
            document.getElementById("phoneno").value = obj.phoneno;
            document.getElementById("dob").value = obj.dob;
            document.getElementById("staffname").value = obj.name;
            document.getElementById("role").value = obj.role;
            document.getElementById("staffCode").innerText = text;
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
    var salary = document.getElementById("salary").value;
    var role = document.getElementById("role").value;
    var dob = document.getElementById("dob").value;
    var name = document.getElementById("staffname").value;
    var phoneno = document.getElementById("phoneno").value;
    var staffCode = document.getElementById("staffCode").innerText;
    btn.innerHTML = "Loading";
    btn.disabled = true;
    var formdata = 'name=' + name + '& staffCode=' + staffCode + '&role=' + role + '&dob=' + dob + '&phoneno=' + phoneno + '&salary=' + salary + '&address=' + address + '';
    console.log(formdata);


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/edit/staff");
    btn.innerHTML = "Loading";
    btn.disabled = true;

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            feedback = JSON.parse(xhr.responseText);
            document.getElementById('staffform').style.display = 'none';

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
    onloadStaffs();
}

function onclearForm() {
    document.getElementById("address").value = "";
    document.getElementById("salary").value = "";
    document.getElementById("phoneno").value = "";
    document.getElementById("dob").value = "";
    document.getElementById("staffname").value = "";
    document.getElementById("role").value = "";
    document.getElementById("staffCode").innerText = "";;
    document.getElementById('btn2').style.display="none";

    var btn = document.getElementById('btn');
    btn.style.display="block";
    btn.innerHTML = " Save Student ";
    btn.disabled = false;
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
  function unFormat(amt) {
    var str = amt;
    while (str.indexOf(",") > 0) {
      var str1 = str.replace(",", "");
      str = str1;
    }
    return str;
  }
  async function onDeleteStaff(row) {
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
    deleteid = staffs[txt-1].staffCode;
    document.getElementById('deleteForm').style.display = 'block';
    var btnyes = document.getElementById('Yes');
    document.getElementById('delmsg').innerHTML="Are you sure you want to Delete?";
    if (btnyes.addEventListener) {     // For all major browsers, except IE 8 and earlier
        btnyes.addEventListener("click", deleteStaff);
    } else if (x.attachEvent) {   // For IE 8 and earlier versions
        btnyes.attachEvent("onclick", deleteStaff);
    }
}
function deleteStaff() {
    var formdata = 'staffCode=' + deleteid ;
    console.log(formdata);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/kaynikeStudio/system/delete/staff");
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
    onloadStaffs();
}