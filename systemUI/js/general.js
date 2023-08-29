
function openUrl(url) {
    //  host = window.location.hostname;
    //  newURl=host+url;
    window.location.assign(url);

}

function formatUsing(number){
    var comma=3;
    var currency= "";
    for(var i=number.length-1;i >=0;i--){
        
        if(i===comma){
            currency+=",";
            comma+=3;
            currency+=number[i];
        }else{
            currency+=number[i];
        }
    }
    return currency;

}