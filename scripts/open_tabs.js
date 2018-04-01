// $(function () {
//     // $("#HTML").css("display", "block");
//     // $("div.tab button:first-child" ).addClass(" active");
//     $(".content").click(function () {
//         $(this).animate({opacity: "0"}, 200);
//         var links = document.getElementsByClassName("links");
//         for (i = 0; i < links.length; i++) {
//             links[i].className = links[i].className.replace(" active", "");
//         }
//     });
// });
var links = document.getElementsByClassName("links");
for (i = 0; i < links.length; i++) {
    links[i].className = links[i].className.replace(" active", "");
}
ev.currentTarget.className += " active";

function openLang(e, lang) {
    var links = document.getElementsByClassName("links");
    var content = document.getElementsByClassName("content");

    for (i = 0; i < content.length; i++) {
        content[i].style.display = "none";
    }

    for (i = 0; i < links.length; i++) {
        links[i].className = links[i].className.replace(" active", "");
    }

    document.getElementById(lang).style.display = "block";
    document.getElementById(lang).style.opacity = "1";
    e.currentTarget.className += " active";
    ev = e;
}


