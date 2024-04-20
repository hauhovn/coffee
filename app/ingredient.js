const API_URL = "http://127.0.0.1/api/ingredient.php";

// Gửi yêu cầu GET để lấy tất cả các nguyên liệu
export async function getIngredients(limit = 0) {

    const newUri = API_URL + (limit == 0 ? "" : `?limit=${limit}`);
    // [GET] ingredients
    await fetch(newUri)
        .then(function (res) { return res.json() })
        .then(function (data) {
            console.table(data)
        }).catch(error => {
            // Xử lý lỗi
            console.error('Error:', error);
        });
}

// Gửi yêu cầu POST để tạo mới một nguyên liệu
export function createIngredient(name, price, unit) {
    const newData = {
        name: name,
        price: price,
        unit: unit
    };

    const options = {
        mode: 'no-cors',
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ...newData })
    };
    console.log(`option`, options);

    fetch(API_URL, options)
        .then(response => response.json())
        .then(data => {
            // Xử lý dữ liệu được trả về
            console.log('Response:', data);
        })
        .catch(error => {
            // Xử lý lỗi
            console.error('Error:', error);
        });
}



