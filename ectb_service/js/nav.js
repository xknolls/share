function myFunction() {
    var x = document.getElementById("myLinks");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}

function filter() {

    let nav = document.querySelector('.filter-nav');

    console.log(nav);
    
    
    $('.filter-nav').on('click', '.filter-link', function(){
        let filter = this.getAttribute('data-filter');
        console.log(filter);

        $.get('./admin.php?filter=' + filter);
        console.log('test');
    })
}