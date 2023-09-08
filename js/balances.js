var balances = [];


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



////////////////////////////
////////Bills file.
///////
// //////////////////////////////
async function onloadBalances() {
  var table = document.getElementById("table");
  onclearTable(table);
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "http://localhost/KanyikeStudio/system/find/balances", true);
  xhttp.send();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);
      balances = data;
      onPageniation(balances, table);
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
    var service = row.insertCell(1);
    var account = row.insertCell(2);
    var customer = row.insertCell(3);
    var bill = row.insertCell(4);
    var pay = row.insertCell(5);
    var balances = row.insertCell(6);
    var date = row.insertCell(7);
    var remarks = row.insertCell(8);
    var action = row.insertCell(9);
    id.innerHTML = data[i]["reference_id"];
    service.innerHTML = data[i]["productname"];
    account.innerHTML = data[i]["accountName"];
    customer.innerHTML = data[i]["customername"];
    bill.innerHTML = format(data[i]["totalbill"]);
    pay.innerHTML = format(data[i]["totalpayments"]);
    balances.innerHTML =format(data[i]["totalbill"]- data[i]["totalpayments"]);
    date.innerHTML = data[i]["transDate"];
    remarks.innerHTML = data[i]["remarks"];
    action.innerHTML = '<button class="w3-bar-item w3-button w3-red">Delete</button>';
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
    td1 = tr[i].getElementsByTagName("td")[1];
    td2 = tr[i].getElementsByTagName("td")[2];
    td3 = tr[i].getElementsByTagName("td")[3];
    td4 = tr[i].getElementsByTagName("td")[4];
    td5 = tr[i].getElementsByTagName("td")[5];
    td6 = tr[i].getElementsByTagName("td")[6];
    if (td1 || td2 || td3 || td4 || td5 || td6) {
      txtValue1 = td1.textContent || td1.innerText;
      txtValue2 = td2.textContent || td2.innerText;
      txtValue3 = td3.textContent || td3.innerText;
      txtValue4 = td4.textContent || td4.innerText;
      txtValue5 = td5.textContent || td5.innerText;
      txtValue6 = td6.textContent || td6.innerText;


      if (txtValue1.toUpperCase().indexOf(filter) > -1 ||
        txtValue2.toUpperCase().indexOf(filter) > -1 ||
        txtValue3.toUpperCase().indexOf(filter) > -1 ||
        txtValue4.toUpperCase().indexOf(filter) > -1 ||
        txtValue5.toUpperCase().indexOf(filter) > -1 ||
        txtValue6.toUpperCase().indexOf(filter) > -1 ) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
onloadBalances();

function format( amt  ) {
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
   amt= total;
  }

  return amt;
  
}
function unFormat(amt){
  var str =amt;
  while(str.indexOf(",")>0){
  	var str1=str.replace(",","");
  	str=str1;
  }
 return str;
}