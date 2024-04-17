// Gửi yêu cầu GET để lấy tất cả các nguyên liệu 
export function getIngredients() {
    fetch('ingredient_api.php', {
        method: 'GET'
    })
        .then(response => response.json())
        .then(data => {
            // Xử lý dữ liệu được trả về
            console.log('Ingredients:', data);
        })
        .catch(error => {
            // Xử lý lỗi
            console.error('Error:', error);
        });
}

// Gửi yêu cầu POST để tạo mới một nguyên liệu
export async function createIngredient(name, price, quantity, unit) {
    const newData = {
        name: name,
        price: price,
        quantity: quantity,
        unit: unit
    };

    const options = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ...newData })
    };

    await fetch('http://127.0.0.1:80/ingredient_api.php', options)
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

async function createIngredient2(name, price, quantity, unit) {
    let myObject = await fetch(file);
    let myText = await myObject.text();
    myDisplay(myText);
}

