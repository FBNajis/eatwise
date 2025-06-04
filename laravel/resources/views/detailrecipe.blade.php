<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Detail - eatwise</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
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
            list-style: disc;
            padding-left: 20px;
        }


        .ingredient-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
            padding-left: 1.5em; /* space for bullet */
        }

        .ingredient-item::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #27ae60;
            font-size: 1.2em;
            line-height: 1;
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
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        @include('components.sidebar')
        
        <div class="main-content">
            <div class="header">
                <h1 class="recipe-title" id="recipe-title">Loading...</h1>
            </div>

            <div class="recipe-container">
                <div>
                    <img src="" alt="" class="recipe-image" id="recipe-image">
                </div>
                
                <div class="recipe-info">
                    <p class="recipe-description" id="recipe-description">Loading description...</p>
                    
                    <div class="recipe-stats">
                        <div class="stat-item">
                            <i class="fas fa-star stat-icon"></i>
                            <span id="recipe-cost">Loading...</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock stat-icon"></i>
                            <span id="recipe-time">Loading...</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-heart stat-icon"></i>
                            <span id="recipe-likes">0 Likes</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-user stat-icon"></i>
                            <span id="recipe-creator">Loading...</span>
                        </div>
                    </div>
                    
                    <button class="add-to-favorites" id="favorite-button" data-liked="false">
                        <i class="far fa-heart"></i> Add to favorites
                    </button>
                </div>
            </div>

            <div class="content-section">
                <div class="section">
                    <h2 class="section-title">Ingredient</h2>
                    <ul class="ingredient-list" id="ingredient-list"></ul>
                </div>

                <div class="section">
                    <h2 class="section-title">How to cook</h2>
                    <ol class="cooking-steps" id="cooking-steps"></ol>
                </div>
            </div>

            <div class="comments-section">
                <div class="comments-header">
                    <i class="fas fa-comments"></i>
                    <span class="comments-count" id="comments-count">0 Comment</span>
                </div>
                
                <div id="comments-container"></div>

                <div class="comment-input-section">
                    <img src="{{ asset('images/profile.png') }}" alt="Your Avatar" class="comment-avatar" id="current-user-avatar">
                    <textarea class="comment-input" placeholder="Write your comment here..." id="comment-input"></textarea>
                    <button class="comment-submit" id="comment-submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const recipeId = urlParams.get('id');
        const token = localStorage.getItem('token');

        async function fetchUserProfile() {
            if (!token) return;
            
            try {
                const response = await fetch('/api/user', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const json = await response.json();
                    
                    // Update comment avatar dengan foto profil user yang login
                    const currentUserAvatar = document.getElementById('current-user-avatar');
                    if (currentUserAvatar && json.image) {
                        currentUserAvatar.src = json.image;
                    }
                }
            } catch (error) {
                console.error('Error fetching user profile:', error);
            }
        }

        async function fetchRecipe(id) {
            try {
                const response = await fetch(`/api/recipes/${id}`);
                if (!response.ok) throw new Error('Recipe not found');
                const json = await response.json();
                const data = json.data;

                document.getElementById('recipe-title').textContent = data.name;
                document.getElementById('recipe-description').textContent = data.description;
                document.getElementById('recipe-image').src = data.image_path || '/images/placeholder.png';
                document.getElementById('recipe-image').alt = data.name;
                document.getElementById('recipe-cost').textContent = `IDR ${Number(data.cost_estimation).toLocaleString()}`;
                document.getElementById('recipe-time').textContent = `${data.cooking_time} Minutes`;
                document.getElementById('recipe-likes').textContent = `${data.favorites_count || 0} Likes`;
                document.getElementById('recipe-creator').textContent = data.creator_name || 'Unknown';

                const ingredientsList = document.getElementById('ingredient-list');
                ingredientsList.innerHTML = '';
                if (data.ingredients) {
                    const ingredients = data.ingredients.split('\n').map(i => i.trim()).filter(i => i !== '');
                    ingredients.forEach(item => {
                        const li = document.createElement('li');
                        li.classList.add('ingredient-item');
                        li.textContent = item;
                        ingredientsList.appendChild(li);
                    });
                }

                const stepsContainer = document.getElementById('cooking-steps');
                stepsContainer.innerHTML = '';
                let steps = Array.isArray(data.instructions)
                    ? data.instructions
                    : data.instructions.split('\n').map(s => s.trim()).filter(s => s !== '');

                steps.forEach((step, index) => {
                    const li = document.createElement('li');
                    li.classList.add('cooking-step');
                    li.innerHTML = `<span class="step-number">${index + 1}.</span> ${step}`;
                    stepsContainer.appendChild(li);
                });

            } catch (err) {
                alert('Error loading recipe: ' + err.message);
            }
        }

        async function fetchComments(recipeId) {
            try {
                const response = await fetch(`/api/recipes/${recipeId}/comments`, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error('Failed to fetch comments: ' + errorText);
                }

                const json = await response.json();
                if (!json.data || typeof json.comment_count === 'undefined') {
                    throw new Error('Invalid response format');
                }

                displayComments(json.data);
                updateCommentsCount(json.comment_count);
            } catch (err) {
                console.error('Error loading comments:', err.message);
            }
        }

        async function addComment(commentText) {
            if (!token) {
                alert('Please login to add comments.');
                throw new Error('Unauthorized');
            }

            try {
                const response = await fetch(`/api/recipes/${recipeId}/comments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                    body: JSON.stringify({ comment: commentText })
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error('Server error: ' + errorText);
                }

                await fetchComments(recipeId);
            } catch (err) {
                console.error('Error adding comment:', err.message);
                alert('Error adding comment: ' + err.message);
                throw err;
            }
        }

        async function getUserLikedRecipes() {
            try {
                const response = await fetch(`http://localhost:8000/api/user/recipes/liked`, {
                    headers: { 'Authorization': `Bearer ${token}` },
                });

                if (!response.ok) throw new Error('Failed to fetch liked recipes');

                const data = await response.json();
                return data.data || []; // perbaikan di sini
            } catch (error) {
                console.error('Error:', error);
                return [];
            }
        }


        async function updateFavoriteButtonState() {
            const favoriteButton = document.getElementById('favorite-button');
            if (!favoriteButton) return;

            const likedRecipes = await getUserLikedRecipes();
            const likedRecipeIds = likedRecipes.map(r => r.id);

            if (likedRecipeIds.includes(Number(recipeId))) {
                favoriteButton.dataset.liked = 'true'; // perbaikan di sini
                favoriteButton.innerHTML = '<i class="fas fa-heart"></i> Added to favorites';
                favoriteButton.style.background = '#95a5a6'; // Abu-abu
            } else {
                favoriteButton.dataset.liked = 'false';
                favoriteButton.innerHTML = '<i class="far fa-heart"></i> Add to favorites';
                favoriteButton.style.background = '#e74c3c';
            }
        }


        // === DOM HANDLERS ===
        function displayComments(comments) {
            const commentsContainer = document.getElementById('comments-container');
            commentsContainer.innerHTML = '';

            comments.forEach(comment => {
                const commentElement = document.createElement('div');
                commentElement.className = 'comment-item';

                const userImage = comment.user_image_path || '/images/profile.png';
                const createdAt = new Date(comment.created_at).toLocaleDateString();

                commentElement.innerHTML = `
                    <img src="${userImage}" alt="${comment.username} Avatar" class="comment-avatar">
                    <div class="comment-content">
                        <div class="comment-author">${comment.username}</div>
                        <div class="comment-text">${comment.comment}</div>
                    </div>
                `;

                commentsContainer.appendChild(commentElement);
            });
        }

        function updateCommentsCount(count) {
            const countElement = document.getElementById('comments-count');
            countElement.textContent = `${count} Comment${count !== 1 ? 's' : ''}`;
        }

        // === EVENT LISTENERS ===
        document.getElementById('favorite-button').addEventListener('click', async function () {
            const button = this;
            const liked = button.dataset.liked === 'true';
            const endpoint = `http://localhost:8000/api/recipes/${recipeId}/${liked ? 'unlike' : 'like'}`;
            const method = liked ? 'DELETE' : 'POST';

            const likesCountEl = document.getElementById('recipe-likes');
            let currentLikes = parseInt(likesCountEl.textContent) || 0;
            likesCountEl.textContent = liked ? `${currentLikes - 1} Likes` : `${currentLikes + 1} Likes`;

            if (!token) {
                alert('Please login first.');
                return;
            }

            try {
                const response = await fetch(endpoint, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                    },
                });

                if (response.ok) {
                    if (liked) {
                        button.dataset.liked = 'false'; // Mengubah ke 'false' karena sudah di-unlike
                        button.innerHTML = '<i class="far fa-heart"></i> Add to favorites';
                        button.style.background = '#e74c3c'; // Merah
                    } else {
                        button.dataset.liked = 'true'; // Disukai
                        button.innerHTML = '<i class="fas fa-heart"></i> Added to favorites';
                        button.style.background = '#95a5a6'; // Abu-abu
                    }
                } else if (response.status === 401) {
                    alert('Please login first.');
                } else {
                    alert('Failed to update favorite.');
                }
            } catch (error) {
                console.error('Error favoriting recipe:', error);
                alert('Error occurred. Please try again.');
            }
        });


        document.getElementById('comment-submit').addEventListener('click', async function () {
            const textarea = document.getElementById('comment-input');
            const commentText = textarea.value.trim();

            if (commentText) {
                try {
                    this.disabled = true;
                    await addComment(commentText);
                    textarea.value = '';
                } catch {
                    // already handled
                } finally {
                    this.disabled = false;
                }
            }
        });

        document.getElementById('comment-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('comment-submit').click();
            }
        });

        // === INIT ===
        if (!recipeId) {
            alert('Recipe ID not specified!');
        } else {
            fetchRecipe(recipeId);
            fetchComments(recipeId);
            updateFavoriteButtonState();
            fetchUserProfile(); // Tambahan untuk fetch profil user
        }
    </script>

</body>

</html>