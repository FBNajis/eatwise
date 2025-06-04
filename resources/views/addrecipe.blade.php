<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Recipe - EatWise</title>
  <link rel="stylesheet" href="layout.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style> /* === CSS HOMEPAGE === */
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
}

.sidebar {
  width: 220px;
  padding: 20px;
  background-color: #f8f8f8;
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
  padding: 30px;
}

.header-wrapper {
  position: relative;
  margin-bottom: 60px;
}

.header {
  position: relative;
  background: linear-gradient(to right, #d22222);
  color: white;
  border-radius: 25px;
  padding: 50px;
  height: 250px;
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
  padding: 15px 20px;
  border-radius: 15px;
  font-size: 16px;
  text-align: center;
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
}

.card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
}

.card h3 {
  margin: 10px;
  font-size: 18px;
}

.card p {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 14px;
  color: #666;
  flex-wrap: wrap;
}

.card p .icon {
  width: 16px;
  height: 16px;
  object-fit: contain;
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  gap: 20px;
  justify-items: center;
  padding: 20px;
}

.category-card {
  background: #ffeef0;
  padding: 15px;
  border-radius: 20px;
  width: 100px;
  height: 120px;
  text-align: center;
  cursor: pointer;
  transition: 0.3s;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.category-card img {
  width: 50px;
  height: 50px;
  object-fit: contain;
  margin-bottom: 10px;
}

.category-card p {
  font-size: 14px;
  color: #222;
  font-weight: 500;
  margin: 0;
}

.category-card.active {
  border: 2px solid #2f80ed;
  background: #ffffff;
}

/* === CSS RECOMENDATION === */
body {
  background: #f5f5f5;
}

.container {
  height: 100vh;
}

.sidebar {
  background: #f0f0f0;
  box-shadow: 2px 0 5px rgba(0,0,0,0.05);
}

.sidebar nav button {
  display: block;
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border: none;
  border-radius: 10px;
  background: white;
  cursor: pointer;
  text-align: left;
  font-weight: bold;
  color: red;
  transition: 0.2s;
}

.sidebar nav button.active,
.sidebar nav button:hover {
  background-color: red;
  color: white;
}

.main-content {
  background: white;
}

.header {
  background: #d22222;
  padding: 20px;
  border-radius: 10px;
  margin-bottom: 25px;
}

.back-btn,
.like-btn {
  background: white;
  color: #d22222;
  border: none;
  padding: 8px 12px;
  border-radius: 50%;
  font-size: 16px;
  cursor: pointer;
}

.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
}

.card {
  padding: 10px;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  text-align: left;
}

.card img {
  border-radius: 8px;
}

.author {
  font-size: 12px;
  color: gray;
  margin: 6px 0 2px;
}

.card h3 {
  margin: 10px;
  font-size: 18px;
}

.price {
  font-size: 14px;
  color: #d22222;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.likes {
  color: #d22222;
}

/* === CSS FILTER === */
body {
  background: #f9f9f9;
}

.sidebar {
  width: 260px;
  overflow-y: auto;
}

.logo {
  font-size: 24px;
  margin-bottom: 30px;
}

.filter-section {
  margin-bottom: 30px;
}

.filter-section h3 {
  margin-bottom: 10px;
  color: #333;
}

.price-filters {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 2 kolom dengan lebar sama */
  gap: 10px; /* jarak antar tombol */
}

.price-filters button {
  padding: 10px 0;
  font-weight: bold;
  border-radius: 20px;
  border: none;
  background-color: #ccc;
  color: white;
  text-align: center;
}

.price-filters button.active {
  background-color: red;
  color: white;
}

.category-list {
  list-style: none;
}

.category-list li button {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 2px solid red;
  border-radius: 10px;
  background-color: white;
  font-weight: bold;
  color: red;
  cursor: pointer;
  gap: 10px;
}

.category-list li button.active {
  background-color: red;
  color: white;
}

.category-list li button img {
  width: 40px;
  height: 40px;
  object-fit: contain;
}

.header h2 {
  background-color: #d22222;
  color: white;
  padding: 20px;
  border-radius: 10px;
  font-size: 25px;
  margin-bottom: 25px;
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

.create-btn img {
  width: 18px;
  height: 18px;
}

.edit-form .form-group {
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.edit-form input,
.edit-form textarea {
  padding: 10px;
  border: 1px solid #f4c5c5;
  border-radius: 8px;
  background: #fff3f3;
  font-size: 14px;
  resize: vertical;
}

textarea {
  background-color: #fff3f3;
  border: 1px solid #f4c5c5;
  border-radius: 8px;
  padding: 10px;
  font-size: 14px;
  resize: vertical;
}

select {
  width: 100%;
  padding: 12px;
  border-radius: 10px;
  border: 1px solid #f3caca;
  background-color: #fff2f2;
  font-size: 15px;
  color: #666;
  font-family: 'Poppins', sans-serif;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

/* Popup Styles */
.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.popup-content {
  background: white;
  padding: 40px;
  border-radius: 30px;
  text-align: center;
  max-width: 400px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.popup-content h3 {
  font-size: 20px;
  margin-bottom: 10px;
  font-weight: 600;
}

.popup-content p {
  color: #555;
  font-size: 14px;
}
</style>
</head>
<body>
    @include('components.sidebar')
  <div class="container">

    <!-- Main Content -->
    <main class="main-content">
      <h2 style="text-align: center; margin-bottom: 30px;">Add Recipe</h2>

      <form class="edit-form" id="addRecipeForm" style="max-width: 600px; margin: 0 auto;">
        <div class="form-group">
          <label>Dish Name</label>
          <input type="text" placeholder="Insert the name of the dish..." required />
        </div>

        <div class="form-group">
          <label>Food Description</label>
          <textarea rows="3" placeholder="Insert a brief description of the dish..." required></textarea>
        </div>

        <div class="form-group">
          <label>Cost Estimation</label>
          <input type="number" placeholder="Insert a cost estimation..." required />
        </div>

        <div class="form-group">
          <label>Cooking Time</label>
          <input type="number" placeholder="Insert a cooking time..." required />
        </div>

        <div class="form-group">
          <label>Ingredients</label>
          <input type="text" placeholder="Enter ingredients..." required />
        </div>

        <div class="form-group">
          <label>Food Image</label>
          <div style="border: 2px dashed #ccc; padding: 20px; text-align: center; color: #999; border-radius: 10px;">
            <img src="{{ asset('images/upload-icon.png') }}" alt="Upload" style="width: 32px; margin-bottom: 10px;" />
            <p><strong style="color: red;">Click to Upload</strong> or drag and drop<br/>(Max. File size: 25 MB)</p>
          </div>
        </div>

        <div class="form-group">
          <label>Instructions</label>
          <textarea rows="5" placeholder="Provide step-by-step instructions..." required></textarea>
        </div>

        <div class="form-group">
          <label>Tags</label>
          <select required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #f5cfcf; background-color: #fff0f0;">
            <option value="">Selected Option</option>
            <option value="Snack">Snack</option>
            <option value="Drink">Drink</option>
            <option value="Dessert">Dessert</option>
            <option value="Rice">Rice</option>
            <option value="Sea Food">Sea Food</option>
            <option value="Salad">Salad</option>
            <option value="Bread">Bread</option>
            <option value="Noodle">Noodle</option>
          </select>
        </div>

        <div style="margin-top: 30px;">
          <button type="submit" style="width: 100%; padding: 15px; background-color: #d22222; color: white; font-weight: bold; font-size: 16px; border-radius: 25px; border: none;">Send</button>
        </div>
      </form>
    </main>
  </div>

  <!-- Success Popup -->
  <div id="success-popup" class="popup-overlay" style="display: none;">
    <div class="popup-content">
      <img src="{{ asset('images/success.png') }}" alt="Success" style="width: 150px; margin-bottom: 20px;" />
      <h3>Recipe Successfully Created!</h3>
      <p>Your recipe has been successfully created. Check your recipe now!</p>
    </div>
  </div>

  <!-- Script to show popup -->
  <script>
    const form = document.getElementById('addRecipeForm');
    const popup = document.getElementById('success-popup');

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      popup.style.display = 'flex';
    });
  </script>
</body>
</html>
