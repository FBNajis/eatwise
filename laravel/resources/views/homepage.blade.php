<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EatWise - Home</title>
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
  background-color: #fff;
  color: #333;
}

.container {
  display: flex;
  min-height: 100vh;
}

.sidebar {
  width: 220px;
  padding: 20px;
  background-color: #f8f8f8;
  position: fixed;
  height: 100vh;
  left: 0;
  top: 0;
  overflow-y: auto;
  z-index: 1000;
}

.sidebar .logo img {
  width: 120px;
  margin-bottom: 30px;
}

.menu {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.logo {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 40px;
}

.logo .red {
  color: red;
}

.menu button {
  display: block;
  width: 100%;
  margin-bottom: 15px;
  padding: 10px;
  font-size: 16px;
  background: none;
  border: 2px solid #d43a3a;
  border-radius: 10px;
  cursor: pointer;
}

.menu-btn img {
  width: 20px;
  height: 20px;
}

.menu button.active {
  background-color: #d43a3a;
  color: white;
}

.main-content {
  flex: 1;
  margin-left: 240px;
  padding: 30px;
  min-height: 100vh;
}

.header-wrapper {
  position: relative;
  margin-bottom: 60px;
}

.header {
  position: relative;
  background-image: url("{{ asset('images/banner2.png') }}");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-color: #d22222;
  color: white;
  border-radius: 25px;
  padding: 50px;
  height: 270px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  min-height: 200px;
  overflow: hidden;
  margin-bottom: 30px;
}

.header h1 {
  font-size: 28px;
  font-weight: bold;
  color: white;
}

.header p {
  color: white;
  font-size: 16px;
  margin-top: 5px;
}

.header-img {
  position: absolute;
  right: -50px;
  bottom: -50px;
}

.header-img img {
  height: 280px;
}

.search-bar {
  position: absolute;
  bottom: -25px;
  left: 50%;
  transform: translateX(-50%);
  background: white;
  padding: 1px 10px;
  border-radius: 40px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  display: flex;
  gap: 10px;
  align-items: center;
  width: 80%;
  z-index: 2;
}

.search-bar input {
  flex: 1;
  padding: 10px;
  border-radius: 15px;
  border: none;
  font-size: 16px;
  outline: none;
}

.filter-btn {
  padding: 10px 15px;
  border-radius: 50%;
  border: none;
  background: #eee;
  font-size: 18px;
  cursor: pointer;
}

.categories {
  margin-top: 30px;
  display: grid;
  grid-template-columns: repeat(4, auto); /* Ukuran kolom menyesuaikan isi */
  justify-content: center; /* Tengah secara horizontal */
  grid-template-rows: repeat(2, 1fr);
  gap: 10px;
  max-width: 100%;
}

.category {
  background: #ffe9e9;
  padding: 16px 24px; /* Tambahkan padding agar isi terasa luas */
  border-radius: 12px;
  font-size: 14px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  min-width: 240px; /* Lebarkan box */
  justify-self: center; /* Pusatkan di setiap grid cell */
}



.category img {
  width: 70px;
  height: 70px;
}

.recommendation {
  margin-top: 30px;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.section-header h2 {
  font-size: 24px;
  font-weight: 600;
  color: #333;
}

.current-date {
  font-size: 18px;
  color: #666;
  margin-bottom: 30px;
}

.section-header a {
  color: red;
  font-weight: bold;
  text-decoration: none;
}

.card-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-start; /* ini bikin card mulai dari kiri */
  gap: 3rem; /* jarak antar card, opsional */
}

.card {
  width: 250px;
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  overflow: hidden;
  background: white;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
}

.card h4 {
  margin: 10px;
  font-size: 18px;
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

.create-btn {
  margin-top: 20px;
  z-index: 2;
  position: relative;
  padding: 8px 20px;
  border: none;
  background-color: white;
  color: #d22222;
  font-weight: 600;
  font-size: 16px;
  border-radius: 50px;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  transition: background 0.3s;
}

.create-btn:hover {
  background-color: #f0f0f0;
}

/* Responsive */
@media (max-width: 1024px) {
  .categories {
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
  }
  
  .card-list {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
  }
}

@media (max-width: 768px) {
  .sidebar {
    width: 60px;
    padding: 10px;
  }
  
  .main-content {
    margin-left: 80px;
    padding: 20px;
  }
  
  .logo {
    font-size: 20px;
    margin-bottom: 20px;
  }
  
  .menu button {
    padding: 8px;
    font-size: 14px;
  }
  
  .header {
    padding: 30px 20px;
    height: 200px;
  }
  
  .header h1 {
    font-size: 24px;
  }
  
  .categories {
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
  }
  
  .card {
    width: 100%;
    max-width: 300px;
  }
  
  .card-list {
    justify-content: center;
  }
  
  .search-bar {
    width: 90%;
  }
}
</style>
</head>
<body>
  @include('components.sidebar')
  
  <div class="container">
    
    <main class="main-content">
      <div class="header-wrapper">
        <header class="header">
          <div>
            <h1>Hello, User! 👋</h1> <!-- Default, nanti diganti via JS -->
            <p>Unleash Your Culinary Creativity and Start Cooking Today!</p>
          </div>
          <div class="header-img">
            <img src="{{ asset('images/cookie.png') }}" alt="Food Banner" />
          </div>
        </header>

        <div class="search-bar">
          <input type="text" placeholder="Search recipe...">
          <button class="filter-btn" onclick="window.location.href='/filter'">
            <img src="{{ asset('images/filter.png') }}" alt="Filter" />
          </button>
        </div>
      </div>

      <div class="categories" id="categoriesSection">
        <div class="category">
          <img src="{{ asset('images/snack.png') }}" alt="Snack" />
          <span>Snack</span>
        </div>
        <div class="category">
          <img src="{{ asset('images/drink.png') }}" alt="Drink" />
          <span>Drink</span>
        </div>
        <div class="category">
          <img src="{{ asset('images/dessert.png') }}" alt="Dessert" />
          <span>Dessert</span>
        </div>
        <div class="category">
          <img src="{{ asset('images/rice.png') }}" alt="Rice" />
          <span>Rice</span>
        </div>
        <div class="category">
          <img src="{{ asset('images/seafood.png') }}" alt="Sea Food" />
          <span>Sea Food</span>
        </div>
        <div class="category">
          <img src="{{ asset('images/salad.png') }}" alt="Salad" />
          <span>Salad</span>
        </div>
        <div class="category">
          <img src="{{ asset('images/bread.png') }}" alt="Bread" />
          <span>Bread</span>
        </div>
        <div class="category">
          <img src="{{ asset('images/noodle.png') }}" alt="Noodle" />
          <span>Noodle</span>
        </div>
      </div>

      <section class="recommendation" id="recommendationSection">
        <div class="section-header">
          <h2>Recommendation</h2>
          <a href="{{ route('recommendation') }}">View All</a>
        </div>

        <div class="card-list" id="recipeCardList">
          <!-- Recipes will be loaded here -->
        </div>
      </section>

    </main>
  </div>

  <script>
    // Fungsi debounce: menunda eksekusi fungsi sampai user berhenti mengetik selama delay tertentu
    function debounce(fn, delay) {
      let timer = null;
      return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => {
          fn.apply(this, args);
        }, delay);
      };
    }

    // Format currency IDR
    function formatCurrency(amount) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
      }).format(amount);
    }

    // Tampilkan daftar resep ke dalam elemen card-list
    function displayRecipes(recipes) {
      const cardList = document.getElementById('recipeCardList');
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
          <p class="author">${recipe.creator_name || 'Unknown Author'}</p>
          <h4>${recipe.name}</h4>
          <p class="info">
            <img src="{{ asset('images/harga.png') }}" class="icon" alt="Price"> IDR ${parseInt(recipe.cost_estimation).toLocaleString()} |
            <img src="{{ asset('images/likes.png') }}" class="icon" alt="Likes"> ${recipe.favorites_count || 0} Likes
          </p>
        `;

        cardList.appendChild(card);
      });
    }

    // Load top recipes (default)
    async function loadTopRecipes() {
      const token = localStorage.getItem('token');
      const cardList = document.getElementById('recipeCardList');
      
      if (!token) {
        window.location.href = '/login';
        return;
      }

      cardList.innerHTML = '<p>Loading recipes...</p>';

      try {
        const response = await fetch('/api/recipes/top?limit=4', {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        });

        if (!response.ok) throw new Error('Failed to fetch recipes.');

        const result = await response.json();
        const recipes = result.data || [];

        displayRecipes(recipes);

      } catch (error) {
        console.error('Error fetching recipes:', error);
        cardList.innerHTML = `<p style="color: red;">${error.message}</p>`;
      }
    }

    // Search recipes by query
    async function searchRecipes(query) {
      const token = localStorage.getItem('token');
      const cardList = document.getElementById('recipeCardList');
      const categories = document.getElementById('categoriesSection');

      if (!token) {
        window.location.href = '/login';
        return;
      }

      if (!query) {
        // Jika input kosong, tampilkan kategori dan load top recipes
        categories.style.display = '';
        loadTopRecipes();
        return;
      }

      // Jika ada query, sembunyikan kategori
      categories.style.display = 'none';

      cardList.innerHTML = '<p>Searching recipes...</p>';

      try {
        const response = await fetch(`/api/recipes/search?query=${encodeURIComponent(query)}`, {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json'
          }
        });

        if (!response.ok) throw new Error('Failed to fetch search results.');

        const result = await response.json();
        const recipes = result.data || [];

        displayRecipes(recipes);

      } catch (error) {
        console.error('Search error:', error);
        cardList.innerHTML = `<p style="color: red;">${error.message}</p>`;
      }
    }

    // Debounced version of searchRecipes (delay 500ms)
    const debouncedSearch = debounce((e) => {
      const query = e.target.value.trim();
      searchRecipes(query);
    }, 500);

    // Inisialisasi halaman dan event listener search input
    document.addEventListener('DOMContentLoaded', () => {
      const token = localStorage.getItem('token');
      const user = JSON.parse(localStorage.getItem('user') || '{}');

      if (!token) {
        window.location.href = '/login';
        return;
      }

      const headerTitle = document.querySelector('.header h1');
      if (headerTitle && user.username) {
        headerTitle.textContent = `Hello, ${user.username}! 👋`;
      }

      // Load default top recipes
      loadTopRecipes();

      // Pasang event listener input search dengan debounce
      const searchInput = document.querySelector('.search-bar input[type="text"]');
      if (searchInput) {
        searchInput.addEventListener('input', debouncedSearch);
      }
    });

    // Update tanggal & waktu setiap menit (optional)
    function updateDateTime() {
      const now = new Date();
      const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      };
      const dateTimeString = now.toLocaleDateString('en-US', options);
      const dateElem = document.getElementById('currentDate');
      if (dateElem) {
        dateElem.textContent = dateTimeString;
      }
    }
    updateDateTime();
    setInterval(updateDateTime, 60000);
  </script>
</body>
</html>