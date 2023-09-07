
console.log(sessionStorage.getItem("auth"));
authguard();
function openUrl(url) {
  
  window.location.assign(url);

}
function openReport(url) {
  //  host = window.location.hostname;
  //  newURl=host+url;
  url = "http://localhost/kaynikeStudio/system" + url;

  document.getElementById('reportform').style.display = 'block'
  // document.getElementById("reporturl").scr="http://localhost:5500/index.php";

  // url="http://localhost/kaynikeStudio/system/reports/customers.php";
  // window.open(url, "_blank", " status=no, toolbar=no, menubar=no, location=no, addressbar=no,resizable=yes,top=500,left=200,width=900,height=600");
  var iframe = document.getElementById("myFrame");
  iframe.src = url;//"https://new-website.com";

  console.log(url);


}
function formatCurrency(amt) {
  var patt1 = /[0-9.]/g;
  var value = amt.value;
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
    amt.value = total;
  }

}
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
function ondisplayUsername() {

  // sessionStorage.setItem("username", username);
  // sessionStorage.setItem("password", password);
  // sessionStorage.setItem("auth", true);
  // Retrieve Welcome, <strong> Mike</strong>
  document.getElementById("user").innerHTML = " Welcome, <strong> " + sessionStorage.getItem("username") + "</strong>";

}
function authguard() {
  if (sessionStorage.getItem("auth") === false || sessionStorage.getItem("auth") == null) {
    sessionStorage.removeItem("username");
    sessionStorage.removeItem("password");
    sessionStorage.removeItem("auth");
    sessionStorage.clear();
    openUrl("/index.html");
  } else {
    ondisplayUsername();

  }

}
function onLogout() {
  sessionStorage.removeItem("username");
  sessionStorage.removeItem("password");
  sessionStorage.setItem("auth", false);
  sessionStorage.clear();
  openUrl("/index.html");
}

function onAccordion(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }

}

