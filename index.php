<?php
$pageTitle  = 'Home';
$activePage = 'home';
include __DIR__ . '/includes/header.php';
?>

    <section class="hero hero-video">
        <video class="hero-video-bg" autoplay muted loop playsinline poster="images/hero-poster.jpg">
            <source src="https://rs8.com.ph/wp-content/uploads/2023/06/RS8-Taiwan-Speed-Factory-Redspeed-Motoworkz-Channel-Trailer.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-inner">
            <h1><span class="highlight">Speed</span>, Quality, and Champions!</h1>
            <p class="hero-sub">RS8 Taiwan Speed Factory<br>Excite your life.</p>
            <div class="hero-ctas">
                <a href="#featured" class="btn btn-arrow">Check Our Products</a>
            </div>
        </div>
    </section>

    <section id="featured">
        <div class="container">
            <div class="section-title">
                <span class="eyebrow">Featured Products</span>
                <h2>Race-Ready Components</h2>
                <p>Top-tier parts in the RS8 line-up, engineered for uncompromising performance.</p>
            </div>

            <div class="product-grid">
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="img-wrap"><img src="images/rs8oil.webp" alt="RS8 Racing Line 10W-50"></div>
                    <h3>RS8 Racing Line 10W-50</h3>
                    <div class="product-price">₱350.00</div>
                    <p class="product-desc">100% Synthetic PAO Formulated Racing Oil</p>
                    <div class="details-content">
                        <ul class="product-features">
                            <li>100% Synthetic</li><li>10W-50 API SN</li><li>4T Racing</li><li>JASO MA</li><li>Racing Line</li><li>PAO Formulated</li>
                        </ul>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button class="details-btn btn" style="flex: 1; background: #333;">View Details</button>
                        <button class="add-to-cart-btn btn" style="flex: 1;" data-id="p1" data-name="RS8 Racing Line 10W-50" data-price="350.00" data-image="images/rs8oil.webp">Add to Cart</button>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <div class="img-wrap"><img src="images/torquedrive.webp" alt="RS8 Torque Drive"></div>
                    <h3>RS8 Torque Drive Half Sheeve</h3>
                    <div class="product-price">₱1,680.00</div>
                    <p class="product-desc">Race On! Highspeed Steel Torque Drive for Mio Soul GT 125</p>
                    <div class="details-content">
                        <ul class="product-features">
                            <li>Touring and Race Proven</li><li>Performance Guaranteed</li><li>High Speed Profile Design</li><li>Precision Machining</li><li>Easy Tuning and Installation</li>
                        </ul>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button class="details-btn btn" style="flex: 1; background: #333;">View Details</button>
                        <button class="add-to-cart-btn btn" style="flex: 1;" data-id="p2" data-name="RS8 Torque Drive Half Sheeve" data-price="1680.00" data-image="images/torquedrive.webp">Add to Cart</button>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card">
                    <div class="img-wrap"><img src="images/rs8bell.webp" alt="RS8 Performance Clutch Bell"></div>
                    <h3>RS8 Performance Clutch Bell</h3>
                    <div class="product-price">₱1,380.00</div>
                    <p class="product-desc">Engineered for PCX, ADV, and Click</p>
                    <div class="details-content">
                        <ul class="product-features">
                            <li>Anti Dragging Formula</li><li>Dynamically Balanced</li><li>Touring and Race Proven</li><li>Performance Guaranteed</li>
                        </ul>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button class="details-btn btn" style="flex: 1; background: #333;">View Details</button>
                        <button class="add-to-cart-btn btn" style="flex: 1;" data-id="p3" data-name="RS8 Performance Clutch Bell" data-price="1380.00" data-image="images/rs8bell.webp">Add to Cart</button>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card">
                    <div class="img-wrap"><img src="images/rs8clutchassy.webp" alt="RS8 Lightweight Clutch Master"></div>
                    <h3>RS8 Clutch Master</h3>
                    <div class="product-price">₱1,680.00</div>
                    <p class="product-desc">Super Lightweight Clutch Master Assembly</p>
                    <div class="details-content">
                        <ul class="product-features">
                            <li>Anti Dragging Formula</li><li>Touring and Race Proven</li><li>Performance Guaranteed</li>
                        </ul>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button class="details-btn btn" style="flex: 1; background: #333;">View Details</button>
                        <button class="add-to-cart-btn btn" style="flex: 1;" data-id="p4" data-name="RS8 Clutch Master" data-price="1680.00" data-image="images/rs8clutchassy.webp">Add to Cart</button>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="product-card">
                    <div class="img-wrap"><img src="images/rs8degreaser.webp" alt="RS8 Magic Degreaser"></div>
                    <h3>RS8 Magic Degreaser</h3>
                    <div class="product-price">₱150.00</div>
                    <p class="product-desc">Shine, Protect, Clean and Degrease. Powerful Formula Cleans Quickly and Easily.</p>
                    <div class="details-content">
                        <ul class="product-features">
                            <li>Magic Formulation for Engine, Plastic Parts, Chain</li>
                        </ul>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button class="details-btn btn" style="flex: 1; background: #333;">View Details</button>
                        <button class="add-to-cart-btn btn" style="flex: 1;" data-id="p5" data-name="RS8 Magic Degreaser" data-price="150.00" data-image="images/rs8degreaser.webp">Add to Cart</button>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="product-card">
                    <div class="img-wrap"><img src="images/rs8cap.jpg" alt="RS8 Snapback Mesh Cap"></div>
                    <h3>RS8 Snapback Mesh Cap</h3>
                    <div class="product-price">₱680.00</div>
                    <p class="product-desc">V1 Gray-White (Limited Edition) Team Apparel</p>
                    <div class="details-content">
                        <ul class="product-features">
                            <li>Snapback</li><li>Flat Brim</li><li>Embroidery</li><li>High Quality</li><li>Cotton/Acrylic</li><li>Comes with String Bag</li>
                        </ul>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button class="details-btn btn" style="flex: 1; background: #333;">View Details</button>
                        <button class="add-to-cart-btn btn" style="flex: 1;" data-id="p6" data-name="RS8 Snapback Mesh Cap" data-price="680.00" data-image="images/rs8cap.jpg">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="feature-strip">
        <div class="container">
            <div class="feature-grid">
                <div class="feature">
                    <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 3.5"/></svg></div>
                    <div><h3>Taiwan Precision</h3><p>Every part is machined to tight tolerances by manufacturers who supply the Taiwanese racing scene.</p></div>
                </div>
                <div class="feature">
                    <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2 4 14h7l-1 8 9-12h-7z"/></svg></div>
                    <div><h3>Dyno-Tested</h3><p>Nothing ships until it's proven power gains and reliability on the bench, not just on paper.</p></div>
                </div>
                <div class="feature">
                    <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                    <div><h3>Rider-First Support</h3><p>Talk to a real person about fitment, tuning, and what setup makes sense for your build.</p></div>
                </div>
            </div>
        </div>
    </section>

<?php include __DIR__ . '/includes/footer.php'; ?>