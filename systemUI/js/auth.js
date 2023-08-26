function login(){
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var formdata  = 'username='+username + '& password='+password;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost:3000/login");
    document.getElementById('btn').innerHTML="Loading";
    document.getElementById('btn').disabled=true;
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      document.getElementById('id01').style.display='block';
        if (xhr.readyState == 4 && xhr.status == 200) {
          console.log(xhr.status);
          console.log(this.responseText);
          onDisplay( xhr.status);
        }else{
          onDisplay(xhr.status);
        }
      };
    xhr.send(formdata);
    
}
function onDisplay(status) {
    if (status==200) {
      document.getElementById("message").className = "w3-text-green w3-animate-opacity w3-large";
      document.getElementById("message").innerHTML = "Logged in Successful";
      // var local = window.location.hostname +"/views/DashBoard/dashboard.html";
      window.location.assign("/views/DashBoard/dashboard.html");
    } else {
      document.getElementById("message").className = "w3-text-red w3-animate-opacity w3-large";
      document.getElementById("message").innerHTML = "failed to Log in";
    }
  document.getElementById('btn').innerHTML="Save";
  document.getElementById('btn').disabled=false;
}
