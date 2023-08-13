window.addEventListener('load', function () {
    let showPass = 0;
    document.querySelector('.btn-show-pass').addEventListener('click', function (e) {
        let currentTarget = e.currentTarget;
        if (showPass === 0) {
            currentTarget.nextElementSibling.setAttribute('type','text');
            showPass = 1;
        } else {
            currentTarget.nextElementSibling.setAttribute('type','password');
            showPass = 0;
        }
        currentTarget.querySelector('i').classList.toggle('fa-eye-slash',showPass)
        currentTarget.querySelector('i').classList.toggle('fa-eye',!showPass)

    })
})