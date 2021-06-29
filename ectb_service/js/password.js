; (function () {
    'use strict';

    function displayPassword() {
        var input = document.querySelector('#password');
        if (input.type === "password") {
            input.type = "text";
        }
        else {
            input.type = "password";
        }
    }

    document.querySelector('#displayPassword').addEventListener('click', displayPassword);

})();