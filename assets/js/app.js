var logout_btn = document.querySelector("#logout");
logout_btn.addEventListener("click", function(){
    location.href="logout.php";
});

var upload_file = document.querySelector("#upload_file");
var select_btn = document.querySelector("#select");
var submit_btn = document.querySelector("#submit");
submit_btn.style.display = "none";
upload_file.addEventListener("change", function(){
    if(document.querySelector("#upload_file").value != ""){
        select_btn.style.display = "none";
        submit_btn.style.display = "inline";
    }
})