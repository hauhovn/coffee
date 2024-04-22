const passwordField = document.getElementById('password');
const showPassIcon = document.getElementById('showPass');
const hidePassIcon = document.getElementById('hidePass');

let timer;

showPassIcon.addEventListener('click', function () {
    passwordField.type = 'password';
    showPassIcon.style.display = 'none';
    hidePassIcon.style.display = 'block';
});

hidePassIcon.addEventListener('click', function () {
    passwordField.type = 'text';
    hidePassIcon.style.display = 'none';
    showPassIcon.style.display = 'block';
});

document.getElementById('phone').addEventListener('input', function (e) {
    clearTimeout(timer);
    timer = setTimeout(function () {
        let phone = e.target.value.replace(/\D/g, '');
        if (phone.length > 0) {
            phone = phone.match(/(\d{0,4})(\d{0,3})(\d{0,3})/);
            e.target.value = !phone[2] ? phone[1] : phone[1] + '-' + phone[2] + (phone[3] ? '-' + phone[3] : '');
        }
    }, 500); // 0.5 seconds
});