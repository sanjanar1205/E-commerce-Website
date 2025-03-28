function isUserLoggedIn() {
    return localStorage.getItem('userLoggedIn') === 'true';
}

class WishlistManager {
    constructor() {
        this.storageKey = 'myshop_wishlist';
        this.wishlistItems = this.loadWishlist();
    }

    loadWishlist() {
        const stored = localStorage.getItem(this.storageKey);
        return stored ? JSON.parse(stored) : [];
    }

    saveWishlist() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.wishlistItems));
        this.updateWishlistUI();
        this.updateHeaderCount();
    }

    addToWishlist(product) {
        if (!this.isInWishlist(product.id)) {
            this.wishlistItems.push(product);
            this.saveWishlist();
            return true;
        }
        return false;
    }

    removeFromWishlist(productId) {
        this.wishlistItems = this.wishlistItems.filter(item => item.id !== productId);
        this.saveWishlist();
    }

    isInWishlist(productId) {
        return this.wishlistItems.some(item => item.id === productId);
    }

    getWishlistItems() {
        return this.wishlistItems;
    }

    updateWishlistUI() {
        document.querySelectorAll('.wishlist-button').forEach(button => {
            const productCard = button.closest('.product-card');
            if (productCard) {
                const productId = parseInt(productCard.dataset.productId);
                const icon = button.querySelector('i');
                if (this.isInWishlist(productId)) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    icon.style.color = 'red';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    icon.style.color = '';
                }
            }
        });
    
        this.updateHeaderCount();
    }

    updateHeaderCount() {
        const headerCount = document.querySelector('.nav-icons .wishlist-count');
        if (headerCount) {
            headerCount.textContent = this.wishlistItems.length;
        }
    }
}

// Create global instance
const wishlistManager = new WishlistManager();