const API_URL = 'http://127.0.0.1:8000'

export default {
    categories: `${API_URL}/api/categories`,
    category: function (categoryId) {
        return `${API_URL}/api/categories/${categoryId}`;
    },
    products: function (categoryId) {
        return `${API_URL}/api/categories/${categoryId}/products`
    }
}
