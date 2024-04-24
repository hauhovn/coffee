//Dropdown
document.addEventListener('DOMContentLoaded', function () {
    var dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener('click', function () {
            // Lấy items bên trong dropdown
            var dropdownContents = dropdown.querySelectorAll('.dropdown-content');
            // Có phần tử dầu có class active -> remove : add
            if (dropdownContents[0].classList.value.includes('active')) {
                dropdownContents.forEach(function (item) {
                    item.classList.remove('active');
                })
            } else {
                dropdownContents.forEach(function (item) {
                    item.classList.add('active');
                })
            }
        })
    });
});