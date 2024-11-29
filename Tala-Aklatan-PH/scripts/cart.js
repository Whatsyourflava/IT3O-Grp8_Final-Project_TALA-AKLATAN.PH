function addToCart(bookId) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ book_id: bookId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Book added to cart!');
        } else {
            alert('Failed to add to cart. Please try again.');
        }
    })
    .catch(error => console.error('Error:', error));
}
