var salarys = [];
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
var staff = document.getElementById("staff");
var tdate = document.getElementById("tdate");
var remrks = document.getElementById("remarks");
var amt = document.getElementById("amount");
var payaccount = document.getElementById("payaccount");

var id = "";
var staffpos = "";
var deleteid="";



////////////////////////////
////////Salarys file.
///////
// //////////////////////////////
function onLoadStaffs() {
  var datalist = document.getElementById("samples");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      staffs = data;
      var cnt = 0;
      for (staff of data) {
        var option = document.createElement("option");
        option.value = cnt;
        option.text = staff.name;
        datalist.appendChild(option);
        cnt++;
      }
    }
  };
  xhttp.open("GET", "http://localhost:3000/staffs", true);
  xhttp.send();
}
function onclearSalaryForm() {
  document.getElementById("staff").value = "";
  document.getElementById("tdate").value = "";
  document.getElementById("payaccount").value = "";
  document.getElementById("amount").innerText = 0;
  document.getElementById("remarks").innerText = "";

  var btn = document.getElementById('btn');
  btn.innerHTML = "Pay Salary";
  btn.disabled = false;
}
function onPaySalary() {
  var btn = document.getElementById('btn');
  btn.innerHTML = "Loading";
  btn.disabled = true;

  var formdata = 'staff=' + staffs[staffpos]['staffCode'] + '& remarks=' + remarks.value + '&amount=' + unFormat(amount.value) + '&tdate=' + tdate.value + '&credit=' + payaccount.value + '';
  console.log(formdata);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "http://localhost:3000/new/salary/payment");


  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      feedback = JSON.parse(xhr.responseText);
      btn.innerHTML = "Pay Salary";
      btn.disabled = false;
      document.getElementById('salaryform').style.display = 'none';
      messageBox.style.display = 'block';
      messagepanel.className = "w3-panel w3-green";
      messagetitle.innerHTML = "Success";
      message.innerHTML = feedback.message;

    } else {
      btn.innerHTML = "Pay Salary";
      btn.disabled = false;
      messageBox.style.display = 'block';
      messagepanel.className = "w3-panel w3-red";
      messagetitle.innerHTML = "Failed !";
      message.innerHTML = xhr.responseText;
    }
  };
  xhr.send(formdata);
  onloadSalarys();
}
async function onloadSalarys() {
  var table = document.getElementById("table");
  onclearTable(table);
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "http://localhost:3000/find/salary/payments", true);
  xhttp.send();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      salarys = data;
      onPageniation(salarys, table);
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
    var staffname = row.insertCell(1);
    var account = row.insertCell(2);
    var amount = row.insertCell(3);
    var date = row.insertCell(4);
    var remarks = row.insertCell(5);
    var action = row.insertCell(6);
    id.innerHTML = salarys[i]["reference_id"];;
    account.innerHTML = salarys[i]["accountName"];
    staffname.innerHTML = salarys[i]["name"];
    amount.innerHTML = format(salarys[i]["amount"]);
    date.innerHTML = salarys[i]["transDate"];
    remarks.innerHTML = salarys[i]["remarks"];
    action.innerHTML = '<button class="w3-bar-item w3-button w3-red"  onclick="onDeleteSalary(this)">Delete</button>';
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
  // }
}
async function onNextPage() {
  var table = document.getElementById("table");
  total = accountinfor.length;
  totalpages = Math.ceil(total / size);
  pageno = pageno < totalpages ? pageno + 1 : pageno;
  var index = new Number(0);
  index = (pageno == "1" ? index : (pageno - 1) * size);
  onDisplayTable(index, table);
}
async function onPreviousPage() {
  var table = document.getElementById("table");
  total = accountinfor.length;
  totalpages = Math.ceil(total / size);
  pageno = (pageno - 1) < 1 ? pageno : pageno - 1;
  var index = new Number(0);
  index = (pageno == "1" ? index : (pageno - 1) * size);
  onDisplayTable(index, table);
}
function onfiltervalue() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td1 = tr[i].getElementsByTagName("td")[1];
    td2 = tr[i].getElementsByTagName("td")[2];
    td3 = tr[i].getElementsByTagName("td")[3];
    td4 = tr[i].getElementsByTagName("td")[4];
    td5 = tr[i].getElementsByTagName("td")[5];
    if (td1 || td2 || td3 || td4 || td5) {
      txtValue1 = td1.textContent || td1.innerText;
      txtValue2 = td2.textContent || td2.innerText;
      txtValue3 = td3.textContent || td3.innerText;
      txtValue4 = td4.textContent || td4.innerText;
      txtValue5 = td5.textContent || td5.innerText;


      if (txtValue1.toUpperCase().indexOf(filter) > -1 ||
        txtValue2.toUpperCase().indexOf(filter) > -1 ||
        txtValue3.toUpperCase().indexOf(filter) > -1 ||
        txtValue4.toUpperCase().indexOf(filter) > -1 ||
        txtValue5.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
function onSearchValue(input) {
  var result = input.value;
  if (result != null || result != "") {
    var i = parseInt(result);
    if (!isNaN(i) && i < staffs.length) {
      input.value = staffs[i].name;
      staffpos = i;
    } else {
      input.value = "";
    }
  }

}
onloadSalarys();
onLoadStaffs();
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

async function onDeleteSalary(row) {
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
      btnyes.addEventListener("click", deleteCustomer);
  } else if (x.attachEvent) {   // For IE 8 and earlier versions
      btnyes.attachEvent("onclick", deleteCustomer);
  }
}
function deleteCustomer() {
  var formdata = 'id=' + deleteid ;
  console.log(formdata);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "http://localhost:3000/delete/reference_id");
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
