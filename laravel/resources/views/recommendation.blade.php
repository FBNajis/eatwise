<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recommendation - eatwise</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="layout.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  background-color: #f5f5f5;
  color: #333;
}

.container {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 220px;
  padding: 20px;
  background-color: #fff;
  position: fixed;
  height: 100vh;
  left: 0;
  top: 0;
  overflow-y: auto;
  z-index: 1000;
  box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}

.sidebar .logo {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 30px;
  color: #d43a3a;
}

.menu {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.menu button {
  display: flex;
  align-items: center;
  gap: 15px;
  width: 100%;
  padding: 15px 20px;
  font-size: 16px;
  background: none;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  text-align: left;
  color: #666;
  transition: all 0.3s ease;
}

.menu button:hover {
  background-color: #fff5f5;
  color: #d43a3a;
}

.menu button.active {
  background-color: #d43a3a;
  color: white;
}

.menu-btn-icon {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
}

.main-content {
  flex: 1;
  margin-left: 240px;
  padding: 0;
  min-height: 100vh;
}

.header {
  background-color: #CE181B;
  color: white;
  padding: 50px 50px;
  text-align: center;

  position: relative;
}

.header h1 {
  font-size: 24px;
  font-weight: 600;
  margin: 0;
}

.content-wrapper {
  padding: 30px 50px;
  background-color: #f5f5f5;
}

.section-title {
  font-size: 28px;
  font-weight: 600;
  color: #333;
  margin-bottom: 30px;
  text-align: center;
}

.recipe-grid {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  margin-bottom: 40px;
}

.recipe-card {
  width: 250px;
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  overflow: hidden;
  background: white;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.recipe-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.recipe-image {
  width: 100%;
  height: 150px;
  object-fit: cover;
  background-color: #f0f0f0;
}

.recipe-info {
  padding: 10px;
}

.recipe-author {
  color: #999;
  font-size: 12px;
  margin-bottom: 5px;
}

.recipe-title {
  margin: 10px 0;
  font-size: 18px;
  font-weight: 600;
  color: #333;
}

.recipe-meta {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 14px;
  color: #666;
  flex-wrap: wrap;
}

.meta-icon {
  width: 16px;
  height: 16px;
  object-fit: contain;
}

.price-icon {
  background-color: #28a745;
}

.like-icon {
  background-color: #e74c3c;
}



/* Responsive */
@media (max-width: 768px) {
  .sidebar {
    width: 60px;
    padding: 15px 10px;
  }
  
  .sidebar .logo {
    font-size: 16px;
    text-align: center;
  }
  
  .menu button {
    padding: 15px 10px;
    justify-content: center;
  }
  
  .menu button span {
    display: none;
  }
  
  .main-content {
    margin-left: 80px;
  }
  
  .header {
    padding: 30px 20px;
  }
  
  .header h1 {
    font-size: 28px;
  }
  
  .content-wrapper {
    padding: 20px;
  }
  
  .recipe-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
}

@media (max-width: 480px) {
  .main-content {
    margin-left: 0;
  }
  
  .sidebar {
    transform: translateX(-100%);
  }
  
  .header h1 {
    font-size: 24px;
  }
}
</style>
</head>
<body>
  @include('components.sidebar')
  
  <div class="container">
    
    <main class="main-content">
      <header class="header">
        <h1>Recommendation</h1>
      </header>

      <div class="content-wrapper">
        <div class="recipe-grid" id="recipeContainer">
          <!-- Cards will be generated here -->
        </div>
      </div>
    </main>
  </div>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/recipes/all')
      .then(res => res.json())
      .then(res => {
        const recipes = res.data;
        const container = document.getElementById('recipeContainer');
        container.innerHTML = '';

        recipes.forEach(recipe => {
          const card = document.createElement('div');
          card.className = 'recipe-card';
          card.onclick = () => window.location.href = `/detailrecipe?id=${recipe.id}`;

          const costFormatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
          }).format(recipe.cost_estimation);

          const image = recipe.image_url || '{{ asset("images/default.png") }}';

          card.innerHTML = `
            <img src="${image}" alt="${recipe.name}" class="recipe-image" />
            <div class="recipe-info">
              <p class="recipe-author">${recipe.creator_name}</p>
              <h4 class="recipe-title">${recipe.name}</h4>
              <p class="recipe-meta">
                <img src="{{ asset('images/harga.png') }}" alt="Price" class="meta-icon"> ${costFormatted} |
                <img src="{{ asset('images/likes.png') }}" alt="Like" class="meta-icon"> ${recipe.favorites_count} Likes
              </p>
            </div>
          `;

          container.appendChild(card);
        });
      })
      .catch(error => {
        console.error('Error fetching recipes:', error);
        document.getElementById('recipeContainer').innerHTML = '<p>Gagal memuat resep.</p>';
      });
  });
</script>
</body>
</html>