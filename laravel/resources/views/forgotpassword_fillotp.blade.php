<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password OTP - eatwise</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
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

        /* Right Section - Verification Form */
        .right-section {
            width: 55%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            padding: 40px;
        }

        .verification-form {
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

        .code-input-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 40px 0;
        }

        .code-input {
            width: 60px;
            height: 60px;
            border: 2px solid #e5e7eb;
            border-radius: 30px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            background: white;
            transition: border-color 0.3s;
        }

        .code-input:focus {
            outline: none;
            border-color: #dc2626;
        }

        .resend-text {
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
            color: #666;
        }

        .resend-link {
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
        }

        .resend-link:hover {
            text-decoration: underline;
        }

        .send-btn {
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

        .send-btn:hover {
            transform: translateY(-2px);
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
            
            .verification-form {
                padding: 30px;
            }

            .code-input-container {
                gap: 10px;
            }

            .code-input {
                width: 50px;
                height: 50px;
                font-size: 20px;
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
                        <h2>It's Time to Get Amazing Cooking!</h2>
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
                        <p>Simply enter the ingredients you have, and we'll suggest delicious meals that fit your budget.</p>
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
            <div class="verification-form">
                <div class="form-header">
                    <span class="wave-emoji">👋</span>
                    <h1>Enter Verification Code</h1>
                    <p>Please enter code verification from your email</p>
                </div>

                <form id="otpForm">
                    <div class="code-input-container">
                        <input type="text" class="code-input" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                        <input type="text" class="code-input" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                        <input type="text" class="code-input" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                        <input type="text" class="code-input" maxlength="1" autocomplete="off" inputmode="numeric" pattern="[0-9]*">
                    </div>

                    <div class="resend-text">
                        If you didn't receive a code, 
                        <a href="#" id="resendLink" class="resend-link">Resend (<span id="countdown">60</span>s)</a>
                    </div>

                    <button type="submit" class="send-btn" id="sendBtn">Send</button>
                </form>
            </div>
        </div>
    </div>

    <script>
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
        const email = sessionStorage.getItem('resetEmail'); 
    

      
        if (!email) alert('Email tidak ditemukan, mohon kembali ke halaman sebelumnya.');

        const otpForm = document.getElementById('otpForm');
        const codeInputs = document.querySelectorAll('.code-input');
        const resendLink = document.getElementById('resendLink');
        const countdownSpan = document.getElementById('countdown');
        const sendBtn = document.getElementById('sendBtn');

        let isLoading = false;
        let isResendAvailable = true;
        let countdown = 60;
        let countdownInterval = null;

        function setLoading(state) {
            isLoading = state;
            sendBtn.disabled = state;
            resendLink.style.pointerEvents = state || !isResendAvailable ? 'none' : 'auto';
        }

        function startCountdown() {
            countdown = 60;
            countdownSpan.textContent = countdown;
            isResendAvailable = false;
            resendLink.style.pointerEvents = 'none';

        countdownInterval = setInterval(() => {
                countdown--;
                countdownSpan.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                isResendAvailable = true;
                resendLink.style.pointerEvents = 'auto';
                countdownSpan.textContent = '';
            }
        }, 1000);
        }

        async function sendOtp(email) {
            setLoading(true);
            try {
                const res = await fetch('/api/check-email', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email }),
                });
                const data = await res.json();
                if (res.ok) {
                    alert(data.message || 'OTP sent successfully.');
                    startCountdown();
                } else {
                    alert(data.message || 'Failed to send OTP.');
                }
            } catch (e) {
                alert('Error sending OTP: ' + e.message);
                console.error('Send OTP error:', e);
            } finally {
                setLoading(false);
            }
            
        }


        async function verifyOtp(email, otpCode) {
            setLoading(true);

            try {
                const res = await fetch('/api/verify-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, otp: otpCode }),
                });

                const data = await res.json();

                if (res.ok) {
                    alert(data.message || 'OTP verified successfully.');

                    sessionStorage.setItem('verifiedEmail', email);

                    window.location.href = '/forgotpassword_fillpassword';
                    return true;
                } else {
                    alert(data.message || 'Invalid OTP.');
                    return false;
                }
            } catch (e) {
                alert('Failed to verify OTP.');
                return false;
            } finally {
                setLoading(false);
            }
        }




        resendLink.addEventListener('click', (e) => {
            e.preventDefault();
            if (!isResendAvailable) return;
            sendOtp(email);
        });

        codeInputs.forEach((input, idx) => {
            input.addEventListener('input', (e) => {
                const val = e.target.value;
                if (!/^\d*$/.test(val)) e.target.value = '';
                else if (val.length === 1 && idx < codeInputs.length -1) {
                codeInputs[idx + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                codeInputs[idx - 1].focus();
                }
            });
            input.addEventListener('focus', (e) => e.target.select());
        });

        otpForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const otpCode = Array.from(codeInputs).map(i => i.value).join('');
            if (otpCode.length !== 4) {
                alert('Please enter the complete 4-digit code.');
                return;
            }
                await verifyOtp(email, otpCode,);
        });

        if (email) {
            sendOtp(email);
        }

  </script>

</body>
</html>