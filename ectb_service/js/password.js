; (function () {
    'use strict';

    const checkbox = document.querySelector('#displayPassword');
    
    function displayPassword() {
        let input = document.querySelector('#password');

        if (input.type === "password") {
            input.type = "text";
        }
        else {
            input.type = "password";
        }
    }
    
    if( checkbox !== null ){
        checkbox.addEventListener('click', displayPassword);
    }

})();