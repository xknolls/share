function myFunction() {
    var x = document.getElementById("myLinks");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}

function filter() {

    let links = document.querySelectorAll('.filter-link');

    links.forEach(link => {

        link.addEventListener('click', function () {
            let filter = this.getAttribute('data-filter');

            let url = './filterAjax.php?filter=' + filter;

            console.log(url);

            ajaxGet(url, function (response) {
                let estimate = JSON.parse(response);
                console.log(estimate);
            })


        })
    });

}

function ajaxGet(url, callback) {

    const req = new XMLHttpRequest();

    req.open("GET", url, true);

    req.addEventListener('load', function () {
        if (req.status >= 200 && req.status < 400) {
            callback(req.response);
        } else {
            console.error(req.status + " " + req.statusText + " " + url);
        }
    });

    req.addEventListener('error', function () {
        console.error('Erreur réseau avec l\'url :' + url);
    });

    //fin de la transaction GET
    req.send(null);
}