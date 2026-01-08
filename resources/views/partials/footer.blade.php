<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-shop me-2"></i>The Order
                </h5>
                <p class="text-white-50">
                    Your trusted marketplace for premium preloved items. Quality you can trust, prices you'll love.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-white"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-twitter fs-5"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-youtube fs-5"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 mb-4 mb-lg-0">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none">Shop</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">About Us</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Contact</a></li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-4 mb-4 mb-lg-0">
                <h6 class="fw-bold mb-3">Support</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">FAQ</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Shipping Info</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Returns</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4 col-md-4">
                <h6 class="fw-bold mb-3">Newsletter</h6>
                <p class="text-white-50 small">Subscribe to get special offers and updates</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Your email" style="border-radius: 0.5rem 0 0 0.5rem;">
                    <button class="btn btn-light" type="button" style="border-radius: 0 0.5rem 0.5rem 0;">Subscribe</button>
                </div>
            </div>
        </div>
        
        <hr class="my-4 bg-white opacity-25">
        
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-white-50 small">
                    © {{ date('Y') }} The Order. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 text-white-50 small">
                    Made with <i class="bi bi-heart-fill text-danger"></i> in Indonesia
                </p>
            </div>
        </div>
    </div>
</footer>