<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EatWise - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Left Section - Illustration */
        .left-section {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            width: 45%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 40px;
            left: 40px;
        }

        .logo img {
            height: 40px;
            width: auto;
        }

        .carousel-container {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            width: 100%;
            height: 300px;
        }

        .carousel-slide {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .carousel-slide.active {
            display: block;
            opacity: 1;
        }

        .illustration {
            text-align: center;
            margin-bottom: 40px;
        }

        .bowl {
            width: 200px;
            height: 120px;
            background: linear-gradient(145deg, #ff8a65, #ff7043);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            position: relative;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .bowl::before {
            content: '';
            position: absolute;
            top: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 12px;
            height: 8px;
            background: #333;
            border-radius: 50%;
        }

        .bowl::after {
            content: '';
            position: absolute;
            top: -5px;
            left: 30%;
            width: 8px;
            height: 6px;
            background: #333;
            border-radius: 50%;
        }

        .dice-container {
            position: relative;
            width: 180px;
            height: 80px;
            margin: 0 auto;
        }

        .dice {
            position: absolute;
            width: 50px;
            height: 50px;
            background: linear-gradient(145deg, #e8e8e8, #d0d0d0);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .dice:nth-child(1) {
            left: 0;
            top: 20px;
            transform: rotate(-15deg);
        }

        .dice:nth-child(2) {
            left: 35px;
            top: 0;
            transform: rotate(10deg);
        }

        .dice:nth-child(3) {
            left: 70px;
            top: 25px;
            transform: rotate(-5deg);
        }

        .dice::before, .dice::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            background: #666;
            border-radius: 50%;
        }

        .dice:nth-child(1)::before {
            top: 12px;
            left: 12px;
        }

        .dice:nth-child(1)::after {
            top: 30px;
            left: 30px;
        }

        .dice:nth-child(2)::before {
            top: 20px;
            left: 20px;
        }

        .dice:nth-child(3)::before {
            top: 10px;
            left: 15px;
        }

        .dice:nth-child(3)::after {
            top: 25px;
            left: 30px;
        }

        .leaf {
            position: absolute;
            top: -15px;
            right: 20px;
            width: 20px;
            height: 25px;
            background: #4ade80;
            border-radius: 0 100% 0 100%;
            transform: rotate(45deg);
        }

        /* Alternative illustrations for carousel */
        .chef-hat {
            width: 180px;
            height: 180px;
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            border-radius: 50%;
            position: relative;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .chef-hat::before {
            content: '';
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 80px;
            background: #fff;
            border-radius: 60px 60px 0 0;
            box-shadow: inset 0 -10px 20px rgba(0,0,0,0.1);
        }

        .chef-hat::after {
            content: '👨‍🍳';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 48px;
        }

        .shopping-cart {
            width: 180px;
            height: 140px;
            position: relative;
            margin: 0 auto 20px;
        }

        .cart-body {
            width: 120px;
            height: 80px;
            background: linear-gradient(145deg, #ffd700, #ffb347);
            border-radius: 10px;
            position: relative;
            margin: 0 auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .cart-handle {
            width: 80px;
            height: 50px;
            border: 4px solid #333;
            border-bottom: none;
            border-radius: 40px 40px 0 0;
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
        }

        .cart-wheels {
            position: absolute;
            bottom: -20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }

        .wheel {
            width: 16px;
            height: 16px;
            background: #333;
            border-radius: 50%;
        }

        .content-text {
            text-align: center;
            max-width: 800px;
        }

        .content-text h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: bold;
            line-height: 1.2;
        }

        .content-text p {
            font-size: 16px;
            line-height: 1.5;
            opacity: 0.9;
        }

        .dots {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
        }

        .dot.active {
            background: white;
        }

        /* Right Section - Login Form */
        .right-section {
            width: 55%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            padding: 40px;
        }

        .login-form {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .wave-emoji {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }

        .form-header h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .form-header p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .input-container {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: border-color 0.3s;
            background: #f9fafb;
        }

        .form-group input:focus {
            outline: none;
            border-color: #dc2626;
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
        }

        .forgot-password {
            color: #dc2626;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            border: none;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            margin-bottom: 25px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
        }

        .signup-link {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .signup-link a {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .left-section, .right-section {
                width: 100%;
            }
            
            .left-section {
                height: 40vh;
            }
            
            .right-section {
                height: 60vh;
            }
            
            .login-form {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="logo">
                <img src="{{ asset('images/eatwiselogo.png') }}" alt="EatWise Logo">
            </div>
            
            <div class="carousel-container">
                <!-- Slide 1 -->
                <div class="carousel-slide active">
                    <div class="illustration">
                        <img src="{{ asset('images/noodle.png') }}" alt="Recipe Illustration" style="width: 250px; height: 220px">
                    </div>
                    <div class="content-text">
                        <h2>It’s Time to Get Amazing Cooking!</h2>
                        <p>Start your culinary adventure with Eatwise and enjoy meals that make you feel good.</p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-slide">
                    <div class="illustration">
                        <img src="{{ asset('images/salad.png') }}" alt="Chef Illustration" style="width: 250px; height: 220px">
                    </div>
                    <div class="content-text">
                        <h2>Save Time, Money, and Enjoy Your Meals </h2>
                        <p>Quick, affordable, and easy meal solutions that fit your lifestyle.</p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-slide">
                    <div class="illustration">
                        <img src="{{ asset('images/rice.png') }}" alt="Shopping Illustration" style="width: 250px; height: 250px">
                    </div>
                    <div class="content-text">
                        <h2>Find Recipes Based on What You Have</h2>
                        <p>Simply enter the ingredients you have, and we’ll suggest delicious meals that fit your budget.</p>
                    </div>
                </div>
            </div>
            
            <div class="dots">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <!-- Ganti bagian <form> dengan id agar mudah diakses -->
            <form id="loginForm">
                <div class="form-header">
                    <span class="wave-emoji">👋</span>
                    <h1>Let's Login!</h1>
                    <p>Please provide your information to personalize your experience and start exploring the full potential of the app</p>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Enter your email..." required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-container" style="position: relative;">
                        <input type="password" id="password" placeholder="Enter your password..." required>
                        <span class="password-toggle" onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                            <i class="fa fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <a href="{{ route('forgotpassword_fillemail') }}" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn">Login</button>

                <div class="signup-link">
                    Don't have an account yet? <a href="{{ route('signup') }}">Sign Up</a>
                </div>
            </form>

        </div>
    </div>

    <script>
    // Carousel functionality
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.dot');
    const totalSlides = slides.length;

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    setInterval(nextSlide, 5000);

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }

    // Login form handler
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem('token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));
                localStorage.setItem('email', data.user.email);
                window.location.href = "/homepage";
            } else {
                alert(data.message || 'Login gagal!');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat login.');
        }
    });
</script>

</body>
</html>