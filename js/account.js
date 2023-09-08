var accounttypeInfor = [];
var accountinfor = [];

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
var accttype = document.getElementById("account_type").value;
var acctname = document.getElementById("accountName").value;
var isincome = document.getElementById("isincome").value;
var acctcode = document.getElementById("code").innerText;
var id = "";
var deleteid="";



////////////////////////////
////////Account file.
///////
// //////////////////////////////
function onloadAccountypes() {
  var select = document.getElementById("account_type");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // console.log(this.responseText);
      var data = JSON.parse(this.responseText);
      accounttypeInfor = data;
      for (accounttype of data) {
        var option = document.createElement("option");
        option.value = accounttype.id;
        option.text = accounttype.name;
        select.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "http://localhost/KanyikeStudio/system/accounttypes", true);
  xhttp.send();
  // console.log(accounttypeInfor.length);
}
async function onloadAccountypesData(modif) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      accounttypeInfor = data;
      onmodifyForm(modif, data);

    }
  };
  xhttp.open("GET", "http://localhost/KanyikeStudio/system/accounttypes", true);
  xhttp.send();
  // var data = JSON.parse(xhttp.responseText);
  // accounttypeInfor = data;
  // return accounttypeInfor;
}
function onselectAccountCode(selection) {
  var x = selection.selectedIndex;
  var y = selection.options;
  for (accounttype of accounttypeInfor) {
    if (accounttype.id == y[x].value) {
      document.getElementById("code").innerHTML = accounttype.accountcode;
    }
  }

}
function onclearAccountForm() {
  document.getElementById("account_type").value = "";
  document.getElementById("accountName").value = "";
  document.getElementById("isincome").value = "";
  document.getElementById("code").innerText = "";
  var btn = document.getElementById('btn');
  btn.innerHTML = "Create Account";
  btn.disabled = false;
}
function onCreateAccount() {
  console.log("saving ....")
  var accttype = document.getElementById("account_type").value;
  var acctname = document.getElementById("accountName").value;
  var isincome = document.getElementById("isincome").value == "" ? "NULL" : document.getElementById("isincome").value;
  var acctcode = document.getElementById("code").innerText;
  var btn = document.getElementById('btn');
  btn.innerHTML = "Loading";
  btn.disabled = true;
  var formdata = 'acountCode=' + acctcode + '& isincome=' + isincome + '&accountName=' + acctname + '&account_type=' + accttype + '';
  console.log(formdata);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "http://localhost/KanyikeStudio/system/new/account");


  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    // document.getElementById('id01').style.display='block';
    if (xhr.readyState == 4 && xhr.status == 200) {
      feedback = JSON.parse(xhr.responseText);
      btn.innerHTML = "createAccount";
      btn.disabled = false;
      document.getElementById('accountfom').style.display = 'none';

      messageBox.style.display = 'block';
      messagepanel.className = "w3-panel w3-green";
      messagetitle.innerHTML = "Success";
      message.innerHTML = feedback.message;


    } else {
      // feedback= JSON.parse(xhr.responseText);
      btn.innerHTML = "createAccount";
      btn.disabled = false;
      messageBox.style.display = 'block';
      messagepanel.className = "w3-panel w3-red";
      messagetitle.innerHTML = "Failed !";
      message.innerHTML = xhr.responseText;

    }
  };
  xhr.send(formdata);
  onloadAccounts();
}
async function onloadAccounts() {
  var table = document.getElementById("table");
  onclearTable(table);
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "http://localhost/KanyikeStudio/system/accounts", true);
  xhttp.send();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      accountinfor = data;
      onPageniation(accountinfor, table);
    }
  };
}
function onPageniation(data, table) {
  total = data.length;
  totalpages = Math.ceil(total / size);
  pageno = new Number(1);
  var index = new Number(0);
  index = (pageno == "1" ? index : (pageno - 1) * size);
  // onclearTable(table);
  for (var i = 0; i < data.length; i++) {
    var row = table.insertRow(table.length);
    var id = row.insertCell(0)
    var acctcode = row.insertCell(1);
    var acttname = row.insertCell(2);
    var accttype = row.insertCell(3);
    var isincome = row.insertCell(4);
    var action = row.insertCell(5);
    // console.log(accountinfor[i]["accountName"]);
    id.innerHTML = i + 1;
    acctcode.innerHTML = accountinfor[i]["acountCode"];
    acttname.innerHTML = accountinfor[i]["accountName"].toUpperCase();
    accttype.innerHTML = accountinfor[i]["name"].toUpperCase();
    isincome.innerHTML = accountinfor[i]["isincome"] == "NULL" ? "Not" : accountinfor[i]["isincome"];
    action.innerHTML = '<button class="w3-bar-item w3-button  w3-black" onclick="onEditAccount(this)">Edit</button><button class="w3-bar-item w3-button w3-red" onclick="onDeleteAccount(this)">Delete</button>';
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
  console.log("here with the clicked ")
  console.log(table.rows.length + " " + tr.length);
  console.log(table.rows.length + " " + tr.length);
  while (table.rows.length != 1) {
    for (var i = 1; i < table.rows.length; i++) {
      table.deleteRow(i);
    }
  }
  console.log(table.rows.length + " " + tr.length);
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
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
async function onEditAccount(row) {
  // getting what to onEditAccount;  var i = row.parentNode.parentNode.rowIndex;
  console.log(i);
  var table = document.getElementById("table");
  tr = table.getElementsByTagName("tr");
  td = tr[i].getElementsByTagName("td")[1];
  if (td) {
    txtValue = td.textContent || td.innerText;
    onloadDataonForm(txtValue);
  }
}
async function onloadDataonForm(text) {
  document.getElementById('accountfom').style.display = 'block';
  onloadAccountypes();
  var btn = document.getElementById('btn');
  var edit = document.getElementById('btn2');
  btn.style.display = 'none';

  edit.style.display = 'block';

  var query = 'accountCode=' + text + '';
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "http://localhost/KanyikeStudio/system/accountcode?" + query);
  xhttp.onreadystatechange = function () {

    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      var obj = data[0];
      id = obj.id;
      document.getElementById("account_type").value = obj.account_type;
      document.getElementById("accountName").value = obj.accountName;
      document.getElementById("isincome").value = obj.isincome != "NULL" ? obj.isincome : "";
      document.getElementById("code").innerText = obj.acountCode;
      if (edit.addEventListener) {     // For all major browsers, except IE 8 and earlier
        edit.addEventListener("click", onUpdateAccount);
      } else if (x.attachEvent) {   // For IE 8 and earlier versions
        edit.attachEvent("onclick", onUpdateAccount);
      }
      // edit.onclick= onUpdateAccount();

    }
  };
  xhttp.send(query);
}
function onUpdateAccount() {
  var btn = document.getElementById('btn2');

  var accttype = document.getElementById("account_type").value;
  var acctname = document.getElementById("accountName").value;
  var isincome = document.getElementById("isincome").value == "" ? "NULL" : document.getElementById("isincome").value;
  var acctcode = document.getElementById("code").innerText;

  var formdata = 'acountCode=' + acctcode + '& id=' + id + '& isincome=' + isincome + '&accountName=' + acctname + '&account_type=' + accttype + '';
  console.log(formdata);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "http://localhost/KanyikeStudio/system/edit/account");
  btn.innerHTML = "Loading";
  btn.disabled = true;

  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    // document.getElementById('id01').style.display='block';
    if (xhr.readyState == 4 && xhr.status == 200) {
      feedback = JSON.parse(xhr.responseText);
      document.getElementById('accountfom').style.display = 'none';

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
  onloadAccounts();
}
onloadAccounts();

function onmodifyForm(modif, data) {
  var select = document.getElementById("account_type");
  var expense = document.getElementById("isincome");
  if (select.length > 1) {
    while (select.length > 1) {
      for (var i = 1; i < select.length; i++) {
        select.remove(i);
      }
    }
  }

  if (modif.indexOf("income") > -1) {
    expense.style.display = "block";
    for (accounttype of data) {
      if (accounttype.id.search("NML") > -1) {
        var option = document.createElement("option");
        option.value = accounttype.id;
        option.text = accounttype.name;
        option.selected = true;
        select.add(option);
        select.value = "NML";
      }
    }
  } else if (modif.indexOf("loan") > -1) {
    expense.style.display = "none";
    for (accounttype of data) {
      if (accounttype.id.search("LI") > -1) {
        var option = document.createElement("option");
        option.value = accounttype.id;
        option.text = accounttype.name;
        option.selected = true;
        select.add(option);
        select.value = "LIO";
      }
    }
  } else if (modif.indexOf("Asset") > -1) {
    expense.style.display = "none";
    for (accounttype of data) {
      if (accounttype.id.search("A") > -1) {
        var option = document.createElement("option");
        option.value = accounttype.id;
        option.text = accounttype.name;
        option.selected = true;
        select.add(option);
        select.value = "ACA";
      }
    }
  } else if (modif.indexOf("invest") > -1) {
    expense.style.display = "none";
    for (accounttype of data) {
      if (accounttype.id.search("CPT") > -1) {
        var option = document.createElement("option");
        option.value = accounttype.id;
        option.text = accounttype.name;
        option.selected = true;
        select.add(option);
        select.value = "CPT";
      }
    }
  }

  onselectAccountCode(select);

}
async function onDeleteAccount(row) {
  var i = row.parentNode.parentNode.rowIndex;
  var table = document.getElementById("table");
  tr = table.getElementsByTagName("tr");
  td = tr[i].getElementsByTagName("td")[1];
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
      btnyes.addEventListener("click", deleteAccount);
  } else if (x.attachEvent) {   // For IE 8 and earlier versions
      btnyes.attachEvent("onclick", deleteAccount);
  }
}
function deleteAccount() {
  var formdata = 'acountCode=' + deleteid ;
  console.log(formdata);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "http://localhost/KanyikeStudio/system/delete/account");
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
onloadAccounts();
}
