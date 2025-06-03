<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sate Ayam Pak Slamet - EatWISE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #fff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            max-width: 1200px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .recipe-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }

        .recipe-container {
            display: grid;
            grid-template-columns: 1fr 600px;
            gap: 30px;
            margin-bottom: 40px;
        }

        .recipe-image {
            width: 100%;
            height: 350px;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .recipe-info {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .recipe-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .recipe-stats {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .stat-icon {
            color: #e74c3c;
            width: 20px;
        }

        .add-to-favorites {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }

        .add-to-favorites:hover {
            background: #c0392b;
        }

        .content-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .ingredient-list {
            list-style: none;
        }

        .ingredient-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .ingredient-item:last-child {
            border-bottom: none;
        }

        .ingredient-circle {
            width: 30px;
            height: 30px;
            background: #e8f5e8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
            color: #27ae60;
            font-size: 0.8rem;
        }

        .cooking-steps {
            list-style: none;
        }

        .cooking-step {
            margin-bottom: 15px;
            padding-left: 10px;
        }

        .step-number {
            color: #e74c3c;
            font-weight: bold;
            margin-right: 8px;
        }

        .comments-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .comments-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .comments-count {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .comment-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .comment-content {
            flex: 1;
        }

        .comment-author {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .comment-text {
            color: #666;
            font-size: 0.9rem;
        }

        .comment-input-section {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .comment-input {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
        }

        .comment-submit {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .comment-submit:hover {
            background: #c0392b;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .recipe-container {
                grid-template-columns: 1fr;
            }

            .content-section {
                grid-template-columns: 1fr;
            }

            .recipe-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Include Sidebar Component -->
        @include('components.sidebar')
        
        <div class="main-content">
            <div class="header">
                <h1 class="recipe-title">Sate Ayam Pak Slamet</h1>
            </div>

            <div class="recipe-container">
                <div>
                    <img src="{{ asset('images/sate.png') }}"  alt="Sate Ayam Pak Slamet" class="recipe-image">
                </div>
                
                <div class="recipe-info">
                    <p class="recipe-description">
                        Sate Kambing Pak Slamet offers tender, juicy goat skewers grilled to perfection, served with a rich and flavorful peanut sauce. A must-try for meat lovers! Each skewer is marinated with a secret blend of traditional spices, then grilled over hot charcoal to bring out a smoky aroma that's simply irresistible.
                    </p>
                    
                    <div class="recipe-stats">
                        <div class="stat-item">
                            <i class="fas fa-star stat-icon"></i>
                            <span>IDR 35,000</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock stat-icon"></i>
                            <span>1 Hours, 5 Second</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-heart stat-icon"></i>
                            <span>20 Likes</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-user stat-icon"></i>
                            <span>Anita Dwi Lestari</span>
                        </div>
                    </div>
                    
                    <button class="add-to-favorites">
                        <i class="fas fa-heart"></i> Add to favorites
                    </button>
                </div>
            </div>

            <div class="content-section">
                <div class="section">
                    <h2 class="section-title">Ingredient</h2>
                    <ul class="ingredient-list">
                        <li class="ingredient-item">
                            <div class="ingredient-circle">G</div>
                            <span>Goat meat – IDR 150,000 per kg</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">S</div>
                            <span>Skewers – IDR 5,000 per 100g</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">S</div>
                            <span>Soy sauce – IDR 15,000 per bottle (250 ml)</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">G</div>
                            <span>Garlic – IDR 10,000 per 200g</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">S</div>
                            <span>Shallots – IDR 8,000 per 200g</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">T</div>
                            <span>Turmeric – IDR 5,000 per 100g</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">G</div>
                            <span>Ginger – IDR 8,000 per 200g</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">L</div>
                            <span>Lemongrass – IDR 4,000 per stalk</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">K</div>
                            <span>Kaffir lime leaves – IDR 2,000 per bunch</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">P</div>
                            <span>Peanuts – IDR 25,000 per kg</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">P</div>
                            <span>Palm sugar – IDR 15,000 per 250g</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">T</div>
                            <span>Tamarind – IDR 8,000 per 100g</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">S</div>
                            <span>Salt – IDR 3,000 per kg</span>
                        </li>
                        <li class="ingredient-item">
                            <div class="ingredient-circle">C</div>
                            <span>Cooking oil – IDR 20,000 per liter</span>
                        </li>
                    </ul>
                </div>

                <div class="section">
                    <h2 class="section-title">How to cook</h2>
                    <ol class="cooking-steps">
                        <li class="cooking-step">
                            <span class="step-number">1.</span>
                            Marinate the goat meat: Combine soy sauce, minced garlic, minced shallots, turmeric powder, ground coriander, lemongrass, and kaffir lime leaves in a bowl. Add goat meat cubes and mix well. Let it marinate for 30 minutes to 1 hour.
                        </li>
                        <li class="cooking-step">
                            <span class="step-number">2.</span>
                            Prepare the peanut sauce: Blend roasted peanuts, soaked chiles, palm sugar, tamarind paste, and a pinch of salt in a blender or mortar and pestle. Add water to achieve a smooth, thick sauce.
                        </li>
                        <li class="cooking-step">
                            <span class="step-number">3.</span>
                            Skewer the goat meat: Thread the marinated goat meat onto the skewers, spacing the pieces evenly. Soak wooden skewers in water for 10-15 minutes to prevent burning.
                        </li>
                        <li class="cooking-step">
                            <span class="step-number">4.</span>
                            Grill the skewers: Preheat the grill to medium-high heat. Brush with oil and grill the skewered goat meat for 3-4 minutes per side until cooked through and slightly charred.
                        </li>
                        <li class="cooking-step">
                            <span class="step-number">5.</span>
                            Serve: Serve the grilled sate with the peanut sauce on the side for dipping. Optionally, garnish with lime leaves or chopped cilantro.
                        </li>
                    </ol>
                </div>
            </div>

            <div class="comments-section">
                <div class="comments-header">
                    <i class="fas fa-comments"></i>
                    <span class="comments-count">35 Comment</span>
                </div>
                
                <div class="comment-item">
                    <img src="{{ asset('images/profile.png') }}" alt="User Avatar" class="comment-avatar">
                    <div class="comment-content">
                        <div class="comment-author">anita___</div>
                        <div class="comment-text">seTujuuuu 😍</div>
                    </div>
                </div>

                <div class="comment-input-section">
                    <img src="{{ asset('images/profile.png') }}" alt="Your Avatar" class="comment-avatar">
                    <textarea class="comment-input" placeholder="Write your comment here..."></textarea>
                    <button class="comment-submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add to favorites functionality
        document.querySelector('.add-to-favorites').addEventListener('click', function() {
            const button = this;
            const icon = button.querySelector('i');
            
            if (icon.classList.contains('fas')) {
                icon.classList.remove('fas');
                icon.classList.add('far');
                button.style.background = '#95a5a6';
                button.innerHTML = '<i class="far fa-heart"></i> Added to favorites';
            } else {
                icon.classList.remove('far');
                icon.classList.add('fas');
                button.style.background = '#e74c3c';
                button.innerHTML = '<i class="fas fa-heart"></i> Add to favorites';
            }
        });

        // Comment submission
        document.querySelector('.comment-submit').addEventListener('click', function() {
            const textarea = document.querySelector('.comment-input');
            const commentText = textarea.value.trim();
            
            if (commentText) {
                // Create new comment element
                const newComment = document.createElement('div');
                newComment.className = 'comment-item';
                newComment.innerHTML = `
                    <img src="/api/placeholder/40/40" alt="User Avatar" class="comment-avatar">
                    <div class="comment-content">
                        <div class="comment-author">You</div>
                        <div class="comment-text">${commentText}</div>
                    </div>
                `;
                
                // Insert before the comment input section
                const inputSection = document.querySelector('.comment-input-section');
                inputSection.parentNode.insertBefore(newComment, inputSection);
                
                // Clear the textarea
                textarea.value = '';
                
                // Update comment count
                const countElement = document.querySelector('.comments-count');
                const currentCount = parseInt(countElement.textContent.match(/\d+/)[0]);
                countElement.textContent = `${currentCount + 1} Comment`;
            }
        });

        // Enter key submission for comments
        document.querySelector('.comment-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.querySelector('.comment-submit').click();
            }
        });
    </script>
</body>
</html>