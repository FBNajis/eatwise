<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipe Filter - eatwise</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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

/* Sidebar Styles */
.sidebar {
  width: 250px;
  background: white;
  padding: 20px;
  box-shadow: 2px 0 10px rgba(0,0,0,0.1);
  position: fixed;
  height: 100vh;
  z-index: 1000;
  transition: transform 0.3s ease;
  overflow-y: auto;
}

.logo {
  color: #e53e3e;
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 40px;
}

/* Price Filter Section */
.filter-section {
  margin-bottom: 30px;
}

.filter-title {
  font-size: 16px;
  font-weight: 600;
  color: #333;
  margin-bottom: 15px;
}

.price-buttons {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px;
}

.price-btn {
  padding: 8px 15px;
  border: none;
  border-radius: 20px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: left;
}

.price-btn.active {
  background-color: #e53e3e;
  color: white;
}

.price-btn:not(.active) {
  background-color: #e0e0e0;
  color: #666;
}

.price-btn:hover:not(.active) {
  background-color: #d0d0d0;
}

/* Category Filter Section */
.category-section {
  margin-top: 30px;
}

.category-title {
  font-size: 16px;
  font-weight: 600;
  color: #333;
  margin-bottom: 15px;
}

.categories {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.category {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 15px;
  border: 2px solid #e53e3e;
  border-radius: 25px;
  background: white;
  color: #666;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
}

.category:hover {
  border-color: #e53e3e;
  color: #e53e3e;
}

.category.active {
  background-color: #e53e3e;
  color: white;
  border-color: #e53e3e;
}

.category img {
  width: 20px;
  height: 20px;
  object-fit: contain;
}

/* Main Content */
.main-content {
  flex: 1;
  margin-left: 270px;
  padding: 0;
  min-height: 100vh;
}

.header {
  background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
  color: white;
  padding: 40px 50px;
  text-align: center;
  position: relative;
}

.header h1 {
  font-size: 28px;
  font-weight: 600;
  margin: 0;
}

.content-wrapper {
  padding: 40px 50px;
  background-color: #f5f5f5;
}

/* Recipe Grid - Fixed Layout */
#recipeCardList {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  padding: 40px 50px;
  background-color: #f5f5f5;
}

.card {
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  overflow: hidden;
  background: white;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
}

.card h4 {
  margin: 10px;
  font-size: 18px;
  font-weight: 600;
  color: #333;
}

.card p {
  margin: 0 10px 10px;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 14px;
  color: #666;
  flex-wrap: wrap;
}

.card p.author {
  color: #999;
  font-size: 12px;
  margin-bottom: 5px;
}

.card p .icon {
  width: 16px;
  height: 16px;
  object-fit: contain;
}

/* Responsive Design */
@media (max-width: 1400px) {
  #recipeCardList {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 1000px) {
  #recipeCardList {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
    width: 280px;
  }
  
  .sidebar.active {
    transform: translateX(0);
  }
  
  .main-content {
    margin-left: 0;
  }
  
  .header {
    padding: 30px 20px;
  }
  
  .header h1 {
    font-size: 24px;
  }
  
  #recipeCardList {
    grid-template-columns: 1fr;
    padding: 20px;
  }
}

@media (max-width: 480px) {
  .header h1 {
    font-size: 20px;
  }
  
  #recipeCardList {
    padding: 15px;
  }
}
  </style>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
      <div class="logo">eatwise</div>
      
      <!-- Price Filter Section -->
      <div class="filter-section">
        <h3 class="filter-title">Price</h3>
        <div class="price-buttons">
          <button class="price-btn" data-budget="<15K">< 15K</button>
          <button class="price-btn" data-budget="15K - 30K">15K-30K</button>
          <button class="price-btn" data-budget="30K - 50K">30K-50K</button>
          <button class="price-btn" data-budget="50K - 100K">50K-100K</button>
          <button class="price-btn" data-budget=">100K">> 100K</button>
        </div>
      </div>

      <!-- Category Filter Section -->
      <div class="category-section">
        <h3 class="category-title">Category</h3>
        <div class="categories">
          <div class="category" data-category="Snack">
            <img src="{{ asset('images/snack.png') }}" alt="Snack" />
            <span>Snack</span>
          </div>
          <div class="category" data-category="Drink">
            <img src="{{ asset('images/drink.png') }}" alt="Drink" />
            <span>Drink</span>
          </div>
          <div class="category" data-category="Dessert">
            <img src="{{ asset('images/dessert.png') }}" alt="Dessert" />
            <span>Dessert</span>
          </div>
          <div class="category" data-category="Rice">
            <img src="{{ asset('images/rice.png') }}" alt="Rice" />
            <span>Rice</span>
          </div>
          <div class="category" data-category="Sea Food">
            <img src="{{ asset('images/seafood.png') }}" alt="Sea Food" />
            <span>Sea Food</span>
          </div>
          <div class="category" data-category="Salad">
            <img src="{{ asset('images/salad.png') }}" alt="Salad" />
            <span>Salad</span>
          </div>
          <div class="category" data-category="Bread">
            <img src="{{ asset('images/bread.png') }}" alt="Bread" />
            <span>Bread</span>
          </div>
          <div class="category" data-category="Noodle">
            <img src="{{ asset('images/noodle.png') }}" alt="Noodle" />
            <span>Noodle</span>
          </div>
        </div>
    </div>

    </nav>

    <!-- Main Content -->
    <main class="main-content">
      <header class="header">
        <h1>Recipe Filter</h1>
      </header>

      <div class="card-list" id="recipeCardList">
      </div>

    </main>
  </div>

  <script>
  let selectedBudget = null;
  let selectedCategory = null;

  const sidebar = document.getElementById('sidebar');

  // Tutup sidebar saat klik luar (mobile only)
  document.addEventListener('click', function (event) {
    if (window.innerWidth <= 768 && sidebar && !sidebar.contains(event.target)) {
      sidebar.classList.remove('active');
    }
  });

  // Klik filter budget
  document.querySelectorAll('.price-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.price-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      selectedBudget = this.dataset.budget;
      fetchRecipes(); // Memanggil filterCombined
    });
  });

  // Klik filter category
  document.querySelectorAll('.category').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.category').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      selectedCategory = this.dataset.category;
      fetchRecipes(); // Memanggil filterCombined
    });
  });

  // Fungsi ambil data resep dari API filterCombined
  function fetchRecipes() {
    const params = new URLSearchParams();
    if (selectedBudget) params.append('budget', selectedBudget);
    if (selectedCategory) params.append('category', selectedCategory);

    fetch(`/api/recipes/filter-combined?${params.toString()}`)
      .then(response => {
        if (!response.ok) throw new Error('Invalid response from server');
        return response.json();
      })
      .then(data => {
        displayRecipes(data.data);
      })
      .catch(err => {
        console.error('Error fetching recipes:', err);
      });
  }

  // Fungsi menampilkan resep ke halaman
  function displayRecipes(recipes) {
    const cardList = document.getElementById('recipeGrid') || document.getElementById('recipeCardList');
    cardList.innerHTML = '';

    if (!recipes || recipes.length === 0) {
      cardList.innerHTML = '<p>No recipes found.</p>';
      return;
    }

    recipes.forEach(recipe => {
      const card = document.createElement('div');
      card.className = 'card';
      card.onclick = () => window.location.href = `/detailrecipe?id=${recipe.id}`;

      card.innerHTML = `
        <img src="${recipe.image_path}" alt="${recipe.name}" />
        <p class="author">${recipe.creator_name || recipe.user?.fullname || 'Unknown Author'}</p>
        <h4>${recipe.name}</h4>
        <p class="info">
          <img src="/images/harga.png" class="icon" alt="Price"> IDR ${parseInt(recipe.cost_estimation).toLocaleString()} |
          <img src="/images/likes.png" class="icon" alt="Likes"> ${recipe.favorites_count || 0} Likes
        </p>
      `;

      cardList.appendChild(card);
    });
  }

  document.addEventListener('DOMContentLoaded', fetchRecipes);
</script>


</body>
</html>