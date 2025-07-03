<?php include('header.php'); ?>

<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-error">
        <div>
            <i class="fas fa-exclamation-circle"></i>
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
        <button class="alert-close"
            onclick="this.parentElement.style.opacity=0;setTimeout(()=>this.parentElement.remove(),300)">
            ×
        </button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <div>
            <i class="fas fa-check-circle"></i>
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
        <button class="alert-close"
            onclick="this.parentElement.style.opacity=0;setTimeout(()=>this.parentElement.remove(),300)">
            ×
        </button>
    </div>
<?php endif; ?>

<!-- Hero Section -->
<section class="hero" id="home">
    <canvas id="animated-bg"></canvas>
    <div class="container">

        <div class="hero-content">
            <h1>Take Control of Your Financial Future</h1>
            <p>SpendWise is the professional-grade expense tracker that helps individuals and businesses monitor
                spending, analyze trends, and make smarter financial decisions. With multi-currency support and
                comprehensive reporting, you'll always know where your money goes.</p>
            <div class="cta-buttons">
                <button class="btn btn-primary" id="hero-signup-btn">Start Tracking Now</button>

            </div>
        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                alt="Expense Tracking Dashboard">
        </div>
    </div>
</section>


<!-- Features Section -->
<section class="section" id="features">
    <div class="container">
        <div class="section-title">
            <h2>Powerful Features</h2>
            <p>SpendWise comes packed with professional tools to give you complete control over your finances</p>
        </div>
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3>Visual Analytics</h3>
                <p>Interactive charts and graphs provide clear insights into your spending patterns across all time
                    periods and categories.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <h3>Multi-Currency</h3>
                <p>Track expenses in any currency with automatic exchange rate updates and conversion to your base
                    currency.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3>Custom Categories</h3>
                <p>Create unlimited custom categories and subcategories to match your unique financial structure.
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h3>Smart Alerts</h3>
                <p>Receive notifications when you approach budget limits or have unusual spending activity.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile Optimized</h3>
                <p>Full-featured experience on any device with seamless synchronization across platforms.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Bank-Level Security</h3>
                <p>Your financial data is protected with enterprise-grade encryption and security protocols.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section about" id="about">
    <div class="container">
        <div class="about-content">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1526628953301-3e589a6a8b74?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                    alt="About SpendWise">
            </div>
            <div class="about-text">
                <h2>Professional-Grade Financial Tracking</h2>
                <p>SpendWise was developed by financial experts to provide individuals and small businesses with
                    enterprise-level expense tracking capabilities. Our platform combines sophisticated analytics
                    with an intuitive interface to deliver actionable financial insights.</p>
                <p>Unlike basic expense trackers, SpendWise offers advanced features like customizable reporting
                    periods, tax preparation exports, and team collaboration tools - all while maintaining the
                    simplicity you expect from consumer software.</p>
                <div class="stats">
                    <div class="stat-item">
                        <h3>10K+</h3>
                        <p>Professional Users</p>
                    </div>
                    <div class="stat-item">
                        <h3>50M+</h3>
                        <p>Transactions Analyzed</p>
                    </div>
                    <div class="stat-item">
                        <h3>30+</h3>
                        <p>Global Currencies</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section testimonials" id="testimonials">
    <div class="container">
        <div class="section-title">
            <h2>Trusted by Professionals</h2>
            <p>Financial experts and business owners rely on SpendWise for accurate expense tracking</p>
        </div>
        <div class="testimonial-cards">
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/43.jpg" alt="Sarah J."
                        class="testimonial-avatar">
                    <div class="testimonial-user">
                        <h4>Sarah Johnson</h4>
                        <p>CFO, Tech Startup</p>
                    </div>
                </div>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"As a CFO, I need precise expense tracking with robust reporting.
                    SpendWise provides the professional tools we need without the complexity of enterprise
                    accounting software. The multi-currency support is particularly valuable for our international
                    operations."</p>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael T."
                        class="testimonial-avatar">
                    <div class="testimonial-user">
                        <h4>Michael Thompson</h4>
                        <p>Financial Consultant</p>
                    </div>
                </div>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"I recommend SpendWise to all my clients who need better visibility into
                    their spending. The customizable reports and export features make it easy to integrate with
                    their broader financial planning. It's the perfect bridge between simple apps and complex
                    accounting systems."</p>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Priya K."
                        class="testimonial-avatar">
                    <div class="testimonial-user">
                        <h4>Priya Kumar</h4>
                        <p>Freelance Developer</p>
                    </div>
                </div>
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="testimonial-text">"As someone who works with international clients, SpendWise's currency
                    handling is invaluable. I can track income and expenses in multiple currencies while seeing
                    everything converted to my base currency. The tax preparation exports save me hours each
                    quarter."</p>
            </div>
        </div>
    </div>
</section>

<!-- Signup Modal -->
<div class="modal" id="signup-modal">
    <div class="modal-content">

        <span class="close-modal">&times;</span>
        <h2 class="modal-title">Create Your Account</h2>
        <form id="signup-form" method="POST" action="includes/registrationProcess.php">

            <div class="form-group">
                <label for="signup-name">First Name</label>
                <input type="text" id="first-name" placeholder="first name" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="signup-email">Last Name</label>
                <input type="text" id="last-name" placeholder="last name" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="signup-name">Username</label>
                <input type="text" id="username" placeholder="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" placeholder="Create a password (min 8 chars)"
                    name="password" required minlength="8">
                <i class="fas fa-eye password-toggle" id="toggle-password"></i>
            </div>
            <div class="form-group">
                <label for="signup-confirm-password">Confirm Password</label>
                <input type="password" id="signup-confirm-password" placeholder="Confirm your password"
                    name="confirm_password" required>
                <i class="fas fa-eye password-toggle" id="toggle-confirm-password"></i>
            </div>
            <button type="submit" class="form-submit" name="register">Sign Up</button>
            <div class="form-footer">
                Already have an account? <a href="#login" id="switch-to-login">Log In</a>
            </div>
        </form>
    </div>
</div>

<!-- Login Modal -->
<div class="modal" id="login-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2 class="modal-title">Welcome Back</h2>
        <form id="login-form" method="POST" action="includes/loginProcess.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="login-username" placeholder="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" id="login-password" placeholder="password" name="password" required>
                <i class="fas fa-eye password-toggle" id="toggle-login-password"></i>
            </div>
            <button type="submit" class="form-submit" name="login">Log In</button>
            <div class="form-footer">
                Don't have an account? <a href="#" id="switch-to-signup">Sign Up</a>
            </div>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>