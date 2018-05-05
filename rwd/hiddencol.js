function showDiv(div)
{
    if (document.getElementById(div).style.display=="none")
        document.getElementById(div).style.display="table-cell";
    else
        document.getElementById(div).style.display="none";
}
