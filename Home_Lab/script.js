let item = document.querySelector(".btn")
let MyElement = document.getElementById("list")

item.addEventListener('mouseover', function() {
    MyElement.style.display = "block";
    console.log("MouseOver na opção")
});