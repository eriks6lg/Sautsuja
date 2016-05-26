'use srict';


if(document.getElementById('if-wrong-pass')) {
    alert('Vale kasutajanimi või parool');
}

document.getElementById('submit-button').addEventListener('click',
    function (event) {
        var username = document.getElementById('login-user').value;
        var password = document.getElementById('login-password').value;

        if (username == '' || password == '') {
            alert('Vale kasutajanimi või parool');

            event.preventDefault();
        }
});