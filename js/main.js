

export async function makeRequest(url, method, body) {
    try {
        let response = await fetch(url, {
        method,
        body: body
    })
        let result = await response.json();
        if(result === "Unauthorized"){
            alert("Unauthorized, you are not admin!")
        }else{
            return result;
        }
    } catch(err){
        console.error(err);
    }

}




// Function for fetching all products from the database.
export async function getAllProducts(){

    const action = "getAll";

    let allProducts = await makeRequest(`../api/receivers/productReceiver.php?action=${action}`, "GET");

    return allProducts;
}

export async function getProductById(id) {

    const action = "getById";

    let product = await makeRequest(`../api/receivers/productReceiver.php?action=${action}&id=${id}`, "GET");

    return product;

}

// Function for fetching all products by categoryId.
export async function getAllProductsByCategory(id){
    const action = "getAllById";

    
    let allProductsFromCategory = await makeRequest(`../api/receivers/categoryReciever.php?action=${action}&id=${id}`, "GET");
    
    return allProductsFromCategory

}

// Function for fetching all categories from the database.
export  async function getAllCategories(){

    const action = "getAll";

    let allCategories = await makeRequest(`../api/receivers/categoryReciever.php?action=${action}`, "GET");
   
    return allCategories;
    
    
}

// Function for fetching one category by Id from the database.
export async function getCategoryById(id){

    const action = "getById";

    let category = await makeRequest(`../api/receivers/categoryReciever.php?action=${action}&id=${id}`, "GET");
    
    return category;
}

// Function to get the cart.
export async function getCart(){

    const action = "getCart";

    let cart = await makeRequest(`../api/receivers/cartReciever.php?action=${action}`, "GET");

    return cart;

}



