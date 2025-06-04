<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EatWise - Budget Filter</title>
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

.recipe-grid {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  margin-bottom: 40px;
}

.card {
  width: 250px;
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
@media (max-width: 1200px) {
  .recipe-grid {
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
  
  .content-wrapper {
    padding: 20px;
  }
  
  .recipe-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
}

@media (max-width: 480px) {
  .header h1 {
    font-size: 20px;
  }
  
  .content-wrapper {
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
          <button class="price-btn active">< 15K</button>
          <button class="price-btn">15K-30K</button>
          <button class="price-btn">15K-30K</button>
          <button class="price-btn">15K-30K</button>
        </div>
      </div>
      
      <!-- Category Filter Section -->
      <div class="category-section">
        <h3 class="category-title">Category</h3>
        <div class="categories">
          <div class="category">
            <img src="{{ asset('images/snack.png') }}" alt="Snack" />
            <span>Snack</span>
          </div>
          
          <div class="category active">
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
      </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
      <header class="header">
        <h1>Recipe</h1>
      </header>

      <div class="content-wrapper">
        <div class="recipe-grid" id="recipeGrid">
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/sateayam.png') }}" alt="Sate Ayam" />
            <p class="author">Anila Dwi Lestari</p>
            <h4>Sate Ayam Pak Slamet</h4>
            <p class="info">
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/sempol.png') }}" alt="Sempolan">
            <p class="author">Anila Dwi Lestari</p>
            <h4>Sempolan Ayam Giling</h4>
            <p>
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/bakso.png') }}" alt="Bakso">
            <p class="author">Anila Dwi Lestari</p>
            <h4>Bakso Daging Ayam</h4>
            <p>
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/sateayam.png') }}" alt="Sate Ayam" />
            <p class="author">Anila Dwi Lestari</p>
            <h4>Sate Ayam Pak Slamet</h4>
            <p class="info">
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/sempol.png') }}" alt="Sempolan">
            <p class="author">Anila Dwi Lestari</p>
            <h4>Sempolan Ayam Giling</h4>
            <p>
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/bakso.png') }}" alt="Bakso">
            <p class="author">Anila Dwi Lestari</p>
            <h4>Bakso Daging Ayam</h4>
            <p>
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/sateayam.png') }}" alt="Sate Ayam" />
            <p class="author">Anila Dwi Lestari</p>
            <h4>Sate Ayam Pak Slamet</h4>
            <p class="info">
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/sempol.png') }}" alt="Sempolan">
            <p class="author">Anila Dwi Lestari</p>
            <h4>Sempolan Ayam Giling</h4>
            <p>
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
          <div class="card" onclick="window.location.href='detailrecipe'">
            <img src="{{ asset('images/bakso.png') }}" alt="Bakso">
            <p class="author">Anila Dwi Lestari</p>
            <h4>Bakso Daging Ayam</h4>
            <p>
              <img src="{{ asset('images/harga.png') }}" alt="Price" class="icon"> IDR 150.000 |
              <img src="{{ asset('images/likes.png') }}" alt="Like" class="icon"> 20 Likes
            </p>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Price filter functionality
    document.querySelectorAll('.price-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.price-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });

    // Category filter functionality
    document.querySelectorAll('.category').forEach(btn => {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.category').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
      });
    });

    // Navigate to detail function
    function goToDetail() {
      console.log('Navigating to recipe detail...');
      // Replace with actual navigation logic
      // window.location.href = 'detailrecipe';
    }

    // Mobile responsive functionality
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      
      // Handle window resize
      window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
          sidebar.classList.remove('active');
        }
      });
      
      // Close sidebar when clicking outside on mobile
      document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
          if (!sidebar.contains(event.target)) {
            sidebar.classList.remove('active');
          }
        }
      });
    });
  </script>
</body>
</html>