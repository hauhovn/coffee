// import { getIngredients, createIngredient } from './ingredient.js';

// const getValueBtn = document.getElementById('getValueBtn');


// document.getElementById("ingredientForm").addEventListener("submit", function (event) {
//     event.preventDefault();

//     const formData = new FormData(event.target);
//     //
//     const name = formData.get("name");
//     const price = parseFloat(formData.get("price"));
//     const quantity = parseFloat(formData.get("quantity"));
//     const unit = formData.get("unit");
//     //
//     createIngredient(name, price, quantity, unit);
// });

// getValueBtn.onclick = () => {
//     getIngredients();
// }

// Chuyển hướng đến một trang cụ thể
const isLogin = false;
if (isLogin) {
    window.location.href = "./views/home.html";
} else {
    window.location.href = "./views/login.html";
}
