const avartar = document.getElementById('avartar');


//Dropdown
document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener('click', function () {
            // Lấy items bên trong dropdown
            const dropdownContents = dropdown.querySelectorAll('.dropdown-content');
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
            //Đổi icon
            const dropdownIcon = dropdown.querySelector('.fa-sharp');
            if (dropdownIcon.classList.value.includes('fa-caret-down')){
                dropdownIcon.classList.remove('fa-caret-down');
                dropdownIcon.classList.add('fa-xmark');
            }else{
                dropdownIcon.classList.add('fa-caret-down');
                dropdownIcon.classList.remove('fa-xmark');
            }
        })
    });
});

// Onclick avt
avartar.onclick = ()=>{
    console.log(`he`);
}