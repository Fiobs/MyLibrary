function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;

   // console.log(table);

    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("TR");

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];

            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i+1],rows[i]);
            switching = true;

            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc"){
                dir = "desc";
                switching = true;
            }
        }
    }
}

function deleteCheckedBooks() {

    var checked = document.querySelectorAll('input[name=selected]:checked'),i, arr = [];

    for (i = 0;i < checked.length;i++){
        arr[i] = checked[i]['id'];
    }

    window.location.href = "http://library/books/deleteBooks/?arr="+arr;
}

function deleteCheckedAuthors() {

    var checked = document.querySelectorAll('input[name=selected]:checked'),i, arr = [];

    for (i = 0;i < checked.length;i++){
        arr[i] = checked[i]['id'];
    }

    window.location.href = "http://library/authors/deleteAuthors/?arr="+arr;
}

// let deleteAll = document.querySelector('#deleteAll');
//
// deleteAll.addEventListener('click', () => {
//     console.log(checked);
//     var checked = document.querySelectorAll('input[type=checkbox]:checked');
// });
