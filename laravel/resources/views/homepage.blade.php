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
  display: flex;
  flex-wrap: wrap;
  margin-top: 30px;
  gap: 20px;
}

.category {
  background: #ffe9e9;
  padding: 25px 30px;
  border-radius: 15px;
  font-size: 18px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
  cursor: pointer;
  min-width: 120px;
}

.category img {
  width: 50px;
  height: 50px;
}

.recommendation {
  margin-top: 40px;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
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
  gap: 20px;
  flex-wrap: wrap;
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
  
  .card {
    width: 100%;
    max-width: 300px;
  }
  
  .card-list {
    justify-content: center;
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
            <h1>Hello, Anila! 👋</h1>
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

      <div class="categories">
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

      <section class="recommendation">
        <div class="section-header">
          <h2>Recommendation</h2>
          <a href="{{ route('recommendation') }}">View All</a>
        </div>

        <div class="card-list">
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


  <script>
    // Display current date and time
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
      document.getElementById('currentDate').textContent = dateTimeString;
    }
    
    updateDateTime();
    setInterval(updateDateTime, 60000); // Update every minute
  </script>
</body>
</html>