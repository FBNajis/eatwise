<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Recipe - eatwise</title>
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
  background-color: #fff;
  color: #333;
}

.container {
  display: flex;
  background-color: #fff;
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

.error-message {
  color: red;
  font-size: 0.9em;
  margin-top: 5px;
}

.custom-file-drop {
  border: 2px dashed #ccc;
  padding: 20px;
  text-align: center;
  color: #999;
  border-radius: 10px;
  cursor: pointer;
  position: relative;
}

.custom-file-drop img {
  width: 32px;
  margin-bottom: 10px;
}

.custom-file-drop.hover {
  background-color: #f8f8f8;
}

.custom-file-drop strong {
  color: red;
}

.current-image {
  max-width: 200px;
  border-radius: 10px;
  margin-bottom: 10px;
}

.loading {
  display: none;
  text-align: center;
  color: #666;
  margin-top: 20px;
}

.confirm-popup {
  background: white;
  padding: 30px;
  border-radius: 20px;
  text-align: center;
  max-width: 350px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.confirm-popup h3 {
  color: #d22222;
  margin-bottom: 15px;
}

.confirm-popup .buttons {
  display: flex;
  gap: 15px;
  justify-content: center;
  margin-top: 20px;
}

.confirm-popup button {
  padding: 10px 25px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
}

.confirm-popup .cancel-btn {
  background: #ccc;
  color: #333;
}

.confirm-popup .delete-btn {
  background: #d22222;
  color: white;
}
  </style>
</head>
<body>
  @include('components.sidebar')
  <div class="container">

    <!-- Main Content -->
    <main class="main-content">
      <h2 style="text-align: center; margin-bottom: 30px;">Edit Recipe</h2>

      <!-- Loading indicator -->
      <div class="loading" id="loading">Loading recipe data...</div>

      <form class="edit-form" id="editRecipeForm" style="max-width: 600px; margin: 0 auto;" enctype="multipart/form-data">
        <div class="form-group">
          <label>Dish Name</label>
          <input type="text" name="name" placeholder="Insert the name of the dish..." required />
          <div class="error-message" id="error-name"></div>
        </div>

        <div class="form-group">
          <label>Food Description</label>
          <textarea name="description" rows="3" placeholder="Insert a brief description..." required></textarea>
          <div class="error-message" id="error-description"></div>
        </div>

        <div class="form-group">
          <label>Cost Estimation</label>
          <input type="number" name="cost_estimation" placeholder="Insert a cost estimation..." required />
          <div class="error-message" id="error-cost_estimation"></div>
        </div>

        <div class="form-group">
          <label>Cooking Time (minutes)</label>
          <input type="number" name="cooking_time" placeholder="Insert a cooking time..." required />
          <div class="error-message" id="error-cooking_time"></div>
        </div>

        <div class="form-group">
          <label>Ingredients</label>
          <textarea name="ingredients" rows="3" placeholder="Enter ingredients..." required></textarea>
          <div class="error-message" id="error-ingredients"></div>
        </div>

        <!-- Custom Upload Area -->
        <div class="form-group">
          <label>Food Image</label>
          <div id="currentImageContainer" style="display: none; text-align: center; margin-bottom: 10px;">
            <p style="color: #666; font-size: 14px; margin-bottom: 10px;">Current Image:</p>
            <img id="currentImage" class="current-image" alt="Current recipe image" />
          </div>
          <div class="custom-file-drop" id="drop-area">
            <img src="{{ asset('images/upload-icon.png') }}" alt="Upload" />
            <p><strong>Click to Upload</strong> or drag and drop<br/>(Max. File size: 25 MB)<br/><small>Leave empty to keep current image</small></p>
            <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;" />
          </div>
          <div class="error-message" id="error-image"></div>
          <div id="previewImage" style="margin-top: 10px;"></div>
        </div>

        <div class="form-group">
          <label>Instructions</label>
          <textarea name="instructions" rows="5" placeholder="Provide step-by-step instructions..." required></textarea>
          <div class="error-message" id="error-instructions"></div>
        </div>

        <div class="form-group">
          <label>Tags</label>
          <select name="tag" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #f5cfcf; background-color: #fff0f0;">
            <option value="">Select Option</option>
            <option value="Snack">Snack</option>
            <option value="Drink">Drink</option>
            <option value="Dessert">Dessert</option>
            <option value="Rice">Rice</option>
            <option value="Seafood">Sea Food</option>
            <option value="Salad">Salad</option>
            <option value="Bread">Bread</option>
            <option value="Noodle">Noodle</option>
          </select>
          <div class="error-message" id="error-tag"></div>
        </div>

        <!-- Buttons -->
        <div style="display: flex; justify-content: space-between; margin-top: 30px; gap: 10px;">
          <button type="button" id="deleteBtn" style="background: #d22222; color: white; padding: 15px; border-radius: 25px; border: none; font-weight: bold; cursor: pointer; flex: 1;">Delete</button>
          <button type="submit" style="background: #d22222; color: white; padding: 15px; border-radius: 25px; border: none; font-weight: bold; cursor: pointer; flex: 1;">Edit</button>
        </div>
      </form>
    </main>
  </div>

  <!-- Success Popup -->
  <div id="success-popup" class="popup-overlay" style="display: none;">
    <div class="popup-content">
      <img src="{{ asset('images/success.png') }}" alt="Success" style="width: 150px; margin-bottom: 20px;" />
      <h3>Recipe Successfully Updated!</h3>
      <p>Your recipe has been successfully updated. Check your recipe now!</p>
    </div>
  </div>

  <!-- Delete Confirmation Popup -->
  <div id="delete-popup" class="popup-overlay" style="display: none;">
    <div class="confirm-popup">
      <h3>Delete Recipe?</h3>
      <p>Are you sure you want to delete this recipe? This action cannot be undone.</p>
      <div class="buttons">
        <button class="cancel-btn" id="cancelDelete">Cancel</button>
        <button class="delete-btn" id="confirmDelete">Delete</button>
      </div>
    </div>
  </div>

  <!-- Delete Success Popup -->
  <div id="delete-success-popup" class="popup-overlay" style="display: none;">
    <div class="popup-content">
      <img src="{{ asset('images/success.png') }}" alt="Success" style="width: 150px; margin-bottom: 20px;" />
      <h3>Recipe Successfully Deleted!</h3>
      <p>The recipe has been permanently removed from your collection.</p>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // ================= CONFIGURATION =================
    // TODO: Replace these URLs with your actual API endpoints
    const API_CONFIG = {
      GET_RECIPE: '/api/recipes/{id}', // Replace {id} with actual recipe ID
      UPDATE_RECIPE: '/api/recipes/{id}', // Replace {id} with actual recipe ID  
      DELETE_RECIPE: '/api/recipes/{id}' // Replace {id} with actual recipe ID
    };

    // ================= VARIABLES =================
    const form = document.getElementById('editRecipeForm');
    const successPopup = document.getElementById('success-popup');
    const deletePopup = document.getElementById('delete-popup');
    const deleteSuccessPopup = document.getElementById('delete-success-popup');
    const dropArea = document.getElementById('drop-area');
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const currentImageContainer = document.getElementById('currentImageContainer');
    const currentImage = document.getElementById('currentImage');
    const deleteBtn = document.getElementById('deleteBtn');
    const cancelDelete = document.getElementById('cancelDelete');
    const confirmDelete = document.getElementById('confirmDelete');
    const loading = document.getElementById('loading');

    let recipeId = null;
    let originalImageUrl = null;

    // ================= INITIALIZATION =================
    window.addEventListener('DOMContentLoaded', function() {
      // Get recipe ID from URL parameters
      const urlParams = new URLSearchParams(window.location.search);
      recipeId = urlParams.get('id');
      
      if (!recipeId) {
        alert('Recipe ID not found in URL');
        window.location.href = '/recipe';
        return;
      }

      loadRecipeData();
    });

    // ================= LOAD RECIPE DATA =================
    async function loadRecipeData() {
      loading.style.display = 'block';
      form.style.display = 'none';

      try {
        const response = await fetch(API_CONFIG.GET_RECIPE.replace('{id}', recipeId), {
          method: 'GET',
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
            'Content-Type': 'application/json'
          }
        });

        if (!response.ok) {
          throw new Error('Failed to load recipe data');
        }

        const result = await response.json();
        const recipe = result.data || result; // Handle different API response structures

        // Populate form fields
        form.name.value = recipe.name || '';
        form.description.value = recipe.description || '';
        form.cost_estimation.value = recipe.cost_estimation || '';
        form.cooking_time.value = recipe.cooking_time || '';
        form.ingredients.value = recipe.ingredients || '';
        form.instructions.value = recipe.instructions || '';
        form.tag.value = recipe.tag || '';

        // Handle current image
        if (recipe.image_url || recipe.image) {
          originalImageUrl = recipe.image_url || recipe.image;
          currentImage.src = originalImageUrl;
          currentImageContainer.style.display = 'block';
        }

        loading.style.display = 'none';
        form.style.display = 'block';

      } catch (error) {
        console.error('Error loading recipe:', error);
        alert('Failed to load recipe data. Please try again.');
        loading.style.display = 'none';
        window.location.href = '/recipe';
      }
    }

    // ================= FILE UPLOAD HANDLING =================
    dropArea.addEventListener('click', () => imageInput.click());

    dropArea.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropArea.classList.add('hover');
    });

    dropArea.addEventListener('dragleave', () => dropArea.classList.remove('hover'));

    dropArea.addEventListener('drop', (e) => {
      e.preventDefault();
      dropArea.classList.remove('hover');
      imageInput.files = e.dataTransfer.files;
      showPreview(imageInput.files[0]);
    });

    imageInput.addEventListener('change', () => {
      if (imageInput.files.length > 0) {
        showPreview(imageInput.files[0]);
      }
    });

    function showPreview(file) {
      if (!file.type.startsWith('image/')) return;
      const reader = new FileReader();
      reader.onload = () => {
        previewImage.innerHTML = `
          <p style="color: #666; font-size: 14px; margin-bottom: 10px;">New Image Preview:</p>
          <img src="${reader.result}" style="max-width: 200px; border-radius: 10px;" />
        `;
      };
      reader.readAsDataURL(file);
    }

    // ================= VALIDATION FUNCTIONS =================
    function containsAlphaNumeric(str) {
      return /[a-zA-Z0-9]/.test(str);
    }

    function clearErrors() {
      document.querySelectorAll('.error-message').forEach(el => el.innerText = '');
    }

    function validateForm() {
      clearErrors();

      const name = form.name.value.trim();
      const description = form.description.value.trim();
      const cost_estimation = Number(form.cost_estimation.value);
      const cooking_time = Number(form.cooking_time.value);
      const ingredients = form.ingredients.value.trim();
      const instructions = form.instructions.value.trim();
      const tag = form.tag.value;
      const image = imageInput.files[0];

      let isValid = true;

      // Validate Dish Name
      if (!name || !containsAlphaNumeric(name)) {
        document.getElementById('error-name').innerText = 'Dish name must contain at least one letter or number.';
        isValid = false;
      }

      // Validate Description
      if (!description || !containsAlphaNumeric(description)) {
        document.getElementById('error-description').innerText = 'Description must contain at least one letter or number.';
        isValid = false;
      }

      // Validate Cost Estimation
      if (isNaN(cost_estimation) || cost_estimation < 1000) {
        document.getElementById('error-cost_estimation').innerText = 'Cost estimation must be at least 1000.';
        isValid = false;
      }

      // Validate Cooking Time
      if (isNaN(cooking_time) || cooking_time <= 0) {
        document.getElementById('error-cooking_time').innerText = 'Cooking time must be greater than 0.';
        isValid = false;
      }

      // Validate Ingredients
      if (!ingredients || !containsAlphaNumeric(ingredients)) {
        document.getElementById('error-ingredients').innerText = 'Ingredients must contain at least one letter or number.';
        isValid = false;
      }

      // Validate Instructions
      if (!instructions || !containsAlphaNumeric(instructions)) {
        document.getElementById('error-instructions').innerText = 'Instructions must contain at least one letter or number.';
        isValid = false;
      }

      // Validate Tag
      if (!tag) {
        document.getElementById('error-tag').innerText = 'Please select a tag.';
        isValid = false;
      }

      // Validate Image (optional for edit)
      if (image && image.size > 25 * 1024 * 1024) { // 25 MB limit
        document.getElementById('error-image').innerText = 'File size must be less than 25 MB.';
        isValid = false;
      }

      return isValid;
    }

    // ================= FORM SUBMIT HANDLER =================
    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      if (!validateForm()) return;

      const formData = new FormData();

      formData.append('name', form.name.value.trim());
      formData.append('description', form.description.value.trim());
      formData.append('cost_estimation', form.cost_estimation.value.trim());
      formData.append('cooking_time', form.cooking_time.value.trim());
      formData.append('ingredients', form.ingredients.value.trim());
      formData.append('instructions', form.instructions.value.trim());
      formData.append('tag', form.tag.value);

      // Hanya kirim gambar baru jika user mengganti
      if (imageInput.files.length > 0) {
        formData.append('image', imageInput.files[0]);
      }

      // Tambahkan override method supaya Laravel anggap PUT
      formData.append('_method', 'PUT');

      try {
        const response = await fetch(API_CONFIG.UPDATE_RECIPE.replace('{id}', recipeId), {
          method: 'POST', // pakai POST dengan _method=PUT supaya upload file berhasil
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
            // Jangan set 'Content-Type' karena formData akan otomatis mengatur multipart boundary
          },
          body: formData,
        });

        const result = await response.json();

        if (!response.ok || result.status === false) {
          throw result;
        }

        // Jika berhasil
        successPopup.style.display = 'flex';
        setTimeout(() => {
          successPopup.style.display = 'none';
          window.location.href = '/recipe'; // Arahkan ke daftar resep
        }, 2500);
      } catch (error) {
        console.error('Update error:', error);

        if (error.errors) {
          Object.entries(error.errors).forEach(([field, messages]) => {
            const errorField = document.getElementById(`error-${field}`);
            if (errorField) {
              errorField.innerText = messages[0];
            }
          });
        } else {
          alert('Failed to update recipe. Please try again.');
        }
      }
    });

  // ================= DELETE BUTTON =================
  deleteBtn.addEventListener('click', () => {
    deletePopup.style.display = 'flex';
  });

  cancelDelete.addEventListener('click', () => {
    deletePopup.style.display = 'none';
  });

  confirmDelete.addEventListener('click', async () => {
    try {
      const response = await fetch(API_CONFIG.DELETE_RECIPE.replace('{id}', recipeId), {
        method: 'DELETE',
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token'),
          'Content-Type': 'application/json'
        }
      });

      if (!response.ok) throw new Error('Failed to delete recipe');

      deletePopup.style.display = 'none';
      deleteSuccessPopup.style.display = 'flex';
      setTimeout(() => {
        deleteSuccessPopup.style.display = 'none';
        window.location.href = '/recipe';
      }, 2500);
    } catch (error) {
      alert('Failed to delete recipe.');
      console.error('Delete error:', error);
    }
  });

    // ================= DELETE FUNCTIONALITY =================
    deleteBtn.addEventListener('click', () => {
      deletePopup.style.display = 'flex';
    });

    cancelDelete.addEventListener('click', () => {
      deletePopup.style.display = 'none';
    });

    confirmDelete.addEventListener('click', async () => {
      deletePopup.style.display = 'none';
      
      try {
        const response = await fetch(API_CONFIG.DELETE_RECIPE.replace('{id}', recipeId), {
          method: 'DELETE',
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token'),
            'Content-Type': 'application/json'
          }
        });

        const result = await response.json();

        if (response.ok) {
          deleteSuccessPopup.style.display = 'flex';
        } else {
          alert(result.message || 'Failed to delete recipe.');
        }
      } catch (error) {
        console.error('Error:', error);
        // alert('An unexpected error occurred while deleting the recipe.');
      }
    });

    // ================= POPUP HANDLERS =================
    successPopup.addEventListener('click', () => {
      successPopup.style.display = 'none';
      window.location.href = '/recipe';
    });

    deleteSuccessPopup.addEventListener('click', () => {
      deleteSuccessPopup.style.display = 'none';
      window.location.href = '/recipe';
    });

    // Close popups when clicking outside
    window.addEventListener('click', (e) => {
      if (e.target === deletePopup) {
        deletePopup.style.display = 'none';
      }
    });
  </script>
</body>
</html>