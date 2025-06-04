<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EatWise - Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: white;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar styles for external component */
        
        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            overflow-y: auto;
            height: 100vh;
            background: white;
        }
        
        .main-content.expanded {
            margin-left: 0;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }
        
        .hamburger span {
            width: 20px;
            height: 2px;
            background: #333;
            margin: 2px 0;
            transition: 0.3s;
        }
        
        .page-title {
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }
        
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #f0f0f0;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            position: relative;
            overflow: hidden;
            border: 3px solid #e0e0e0;
            cursor: pointer;
        }
        
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .profile-avatar:hover .avatar-overlay {
            opacity: 1;
        }
        
        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
            font-size: 12px;
            text-align: center;
            padding: 10px;
        }
        
        .avatar-input {
            display: none;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            color: #666;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-input {
            width: 100%;
            padding: 15px;
            border: 1px solid #e0e0e0;
            background: #f8f9fa;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            background: #f0f0f0;
            border-color: #e53e3e;
            box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
        }
        
        .form-input:disabled {
            background: #f8f9fa;
            color: #999;
            cursor: not-allowed;
        }
        
        .password-field {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .btn-primary {
            background: #e53e3e;
            color: white;
        }
        
        .btn-primary:hover:not(:disabled) {
            background: #d63031;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 62, 62, 0.3);
        }
        
        .btn-secondary {
            background: #e53e3e;
            color: white;
        }
        
        .btn-secondary:hover:not(:disabled) {
            background: #d63031;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 62, 62, 0.3);
        }
        
        .btn-edit {
            background: #e53e3e;
            color: white;
        }
        
        .btn-edit:hover {
            background: #d63031;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 62, 62, 0.3);
        }
        
        .btn-cancel {
            background: #e53e3e;
            color: white;
        }
        
        .btn-cancel:hover {
            background: #d63031;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 62, 62, 0.3);
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            display: none;
        }
        
        /* Popup styles */
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .popup-overlay.active {
            display: flex;
        }
        
        .popup-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            max-width: 550px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: popupSlideIn 0.3s ease-out;
        }
        
        .popup-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        
        .popup-message {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        
        .popup-buttons {
            display: flex;
            gap: 15px;
        }
        
        .popup-btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .popup-btn-no {
            background: #e53e3e;
            color: white;
        }
        
        .popup-btn-no:hover {
            background: #d63031;
            transform: translateY(-2px);
        }
        
        .popup-btn-yes {
            background: white;
            color: #e53e3e;
            border: 2px solid #e53e3e;
        }
        
        .popup-btn-yes:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .hamburger {
                display: flex;
            }
            
            .profile-card {
                padding: 30px 20px;
                max-width: 100%;
            }
            
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Include Sidebar Component -->
        @include('components.sidebar')
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <div class="header">
                <div class="hamburger" id="menuToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <h1 class="page-title">Profile</h1>
            </div>
            
            <div class="profile-card">
                <div class="success-message" id="successMessage">
                    Profile updated successfully!
                </div>
                
                <div class="profile-avatar" onclick="triggerImageUpload()">
                    <img id="profileImage" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iNTAiIGZpbGw9IiNmMGYwZjAiLz48cGF0aCBkPSJNNTAgMzBjLTYuNjI3IDAtMTIgNS4zNzMtMTIgMTJzNS4zNzMgMTIgMTIgMTJzMTItNS4zNzMgMTItMTJzLTUuMzczLTEyLTEyLTEyem0wIDQwYy0xMS4wNDYgMC0xOC0zLjI4Mi0xOC04aDM2Yy0wIDQuNzE4LTYuOTU0IDgtMTggOHoiIGZpbGw9IiM5OTk5OTkiLz48L3N2Zz4K" alt="Profile Avatar">
                    <div class="avatar-overlay">
                        Click to change photo
                    </div>
                </div>
                <input type="file" id="avatarInput" class="avatar-input" accept="image/*" onchange="handleImageUpload(event)">
                
                <form id="profileForm">
                    <div class="form-group">
                        <label class="form-label">Fullname</label>
                        <input type="text" name="fullname" id="fullname" class="form-input" value="" disabled>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-input" value="" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone" id="phone" class="form-input" value="" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-input" value="" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="password-field">
                            <input type="password" name="password" id="password" class="form-input" value="" disabled>
                            <span class="password-toggle" onclick="togglePassword('password')">👁</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <div class="password-field">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" value="" disabled>
                            <span class="password-toggle" onclick="togglePassword('password_confirmation')">👁</span>
                        </div>
                    </div>
                    
                    <div class="button-group" id="buttonGroup">
                        <button type="button" class="btn btn-edit" id="editBtn" onclick="enableEdit()">Edit Profile</button>
                        <button type="button" class="btn btn-secondary" onclick="showLogoutConfirm()">Logout</button>
                    </div>
                    
                    <div class="button-group" id="editButtonGroup" style="display: none;">
                        <button type="button" class="btn btn-primary" id="saveBtn">Update Profile</button>
                        <button type="button" class="btn btn-cancel" id="cancelBtn" onclick="cancelEdit()">Cancel</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    
    <!-- Confirmation Popup -->
    <div class="popup-overlay" id="confirmationPopup">
        <div class="popup-content">
            <div class="popup-image"><img src="{{ asset('images/popup.png') }}" alt="Pop up image" style="width: 350px; height: 300px"> </div>
            <div class="popup-title">Are you sure you want to exit the application?</div>
            <div class="popup-message">Your changes will be saved.</div>
            <div class="popup-buttons">
                <button class="popup-btn popup-btn-no" onclick="hideConfirmationPopup()">No</button>
                <button class="popup-btn popup-btn-yes" onclick="confirmLogout()">Yes</button>
            </div>
        </div>
    </div>
    
    <script>
        // Store original values
        let originalValues = {};
        let isEditing = false;
        let hasChanges = false;
        let originalImage = '';
        
        // Sidebar toggle functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', toggleSidebar);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar && sidebar.classList.contains('active')) {
                toggleSidebar();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                if (sidebar) {
                    sidebar.classList.remove('active');
                }
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('active');
                }
                document.body.style.overflow = '';
            }
        });
        
        
        async function fetchProfile() {
            try {
                const token = localStorage.getItem('token');

                if (!token) {
                    alert('User not authenticated. Please login.');
                    return;
                }

                const response = await fetch('/api/user', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch profile data');
                }

                const data = await response.json();

                // Isi input dengan data user
                document.getElementById('fullname').value = data.fullname || '';
                document.getElementById('username').value = data.username || '';
                document.getElementById('phone').value = data.phone || '';
                document.getElementById('email').value = data.email || '';
                document.getElementById('password').value = '';
                document.getElementById('password_confirmation').value = '';

                // Set gambar profil dengan fallback ke default
                const profileImage = document.getElementById('profileImage');
                if (data.image) {
                    profileImage.src = data.image;
                    originalImage = data.image;
                } else {
                    // Tetap gunakan gambar default yang sama seperti sebelumnya
                    originalImage = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iNTAiIGN5PSI1MCIgcj0iNTAiIGZpbGw9IiNmMGYwZjAiLz48cGF0aCBkPSJNNTAgMzBjLTYuNjI3IDAtMTIgNS4zNzMtMTIgMTJzNS4zNzMgMTIgMTIgMTJzMTItNS4zNzMgMTItMTJzLTUuMzczLTEyLTEyLTEyem0wIDQwYy0xMS4wNDYgMC0xOC0zLjI4Mi0xOC04aDM2Yy0wIDQuNzE4LTYuOTU0IDgtMTggOHoiIGZpbGw9IiM5OTk5OTkiLz48L3N2Zz4K";
                    profileImage.src = originalImage;
                }

                // Simpan nilai asli untuk pengecekan perubahan
                originalValues = {
                    fullname: data.fullname || '',
                    username: data.username || '',
                    phone: data.phone || '',
                    email: data.email || '',
                    password: '',
                    password_confirmation: ''
                };

                // Disable semua input saat load
                setInputsDisabled(true);

            } catch (error) {
                console.error('Error fetching profile:', error);
                alert('Failed to load profile data');
            }
        }

        function setInputsDisabled(disabled) {
            const inputs = ['fullname','username', 'phone', 'email', 'password', 'password_confirmation'];
            inputs.forEach(id => {
                const input = document.getElementById(id);
                input.disabled = disabled;
            });
        }
        
        function checkForChanges() {
            const currentImage = document.getElementById('profileImage').src;
            const inputs = ['fullname','username', 'phone', 'email', 'password', 'password_confirmation'];

            hasChanges = currentImage !== originalImage;

            inputs.forEach(id => {
                const input = document.getElementById(id);
                if (input.value !== originalValues[id]) {
                    hasChanges = true;
                }
            });

            // Aktifkan tombol save hanya jika ada perubahan
            document.getElementById('saveBtn').disabled = !hasChanges;
        }
        
        function triggerImageUpload() {
            if (isEditing) {
                document.getElementById('avatarInput').click();
            }
        }

        function handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                    checkForChanges();
                };
                reader.readAsDataURL(file);
            }
        }

        
        // Password toggle functionality
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const toggle = input.nextElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                toggle.textContent = '🙈';
            } else {
                input.type = 'password';
                toggle.textContent = '👁';
            }
        }
        
        // Profile editing functionality
        function enableEdit() {
            isEditing = true;
            setInputsDisabled(false);

            // Clear password fields when editing
            document.getElementById('password').value = '';
            document.getElementById('password_confirmation').value = '';

            // Reset hasChanges agar tombol Save disabled dulu
            hasChanges = false;
            document.getElementById('saveBtn').disabled = true;

            // Tambahkan listener untuk cek perubahan
            const inputs = ['fullname','username', 'phone', 'email', 'password', 'password_confirmation'];
            inputs.forEach(id => {
                document.getElementById(id).addEventListener('input', checkForChanges);
            });

            // Tampilkan tombol Save & Cancel, sembunyikan tombol Edit
            document.getElementById('editButtonGroup').style.display = 'flex';
            document.getElementById('buttonGroup').style.display = 'none';
        }

        // Cancel edit dan kembalikan nilai asli
        function cancelEdit() {
            isEditing = false;
            hasChanges = false;

            const inputs = ['fullname','username', 'phone', 'email', 'password', 'password_confirmation'];
            inputs.forEach(id => {
                const input = document.getElementById(id);
                input.value = originalValues[id];
                input.disabled = true;
                input.removeEventListener('input', checkForChanges);
            });

            document.getElementById('profileImage').src = originalImage;

            document.getElementById('editButtonGroup').style.display = 'none';
            document.getElementById('buttonGroup').style.display = 'flex';

            document.getElementById('saveBtn').disabled = true;
        }
        
        // Popup functionality
        function showConfirmationPopup() {
            document.getElementById('confirmationPopup').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function confirmLogout() {
            // Hapus token dan data user
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            // Tutup popup
            document.getElementById('confirmationPopup').classList.remove('active');
            document.body.style.overflow = 'auto';

            // Redirect ke halaman login
            window.location.href = '/login';
        }
        
        function cancelLogout() {
            document.getElementById('confirmationPopup').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        
        function hideConfirmationPopup() {
            document.getElementById('confirmationPopup').classList.remove('active');
            document.body.style.overflow = '';
        }
        
        function confirmUpdate() {
            hideConfirmationPopup();
            alert('Logged out successfully!');
            console.log('User logged out');
        }
        
        async function performUpdate() {
            
            if (!hasChanges) {
                alert('No changes to save.');
                return;
        }

        const fullname = document.getElementById('fullname').value.trim();
        const username = document.getElementById('username').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const imageSrc = document.getElementById('profileImage').src;

        if (!fullname || !username || !phone || !email) {
            alert('Please fill in all required fields');
            return;
        }

        if (password && password !== confirmPassword) {
            alert('Passwords do not match');
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address');
            return;
        }

        const token = localStorage.getItem('token');
        if (!token) {
            alert('User not authenticated');
            return;
        }

        const formData = new FormData();
        formData.append('fullname', fullname);
        formData.append('username', username);
        formData.append('phone', phone);
        formData.append('email', email);
        if (password) formData.append('password', password);

        const avatarInput = document.getElementById('avatarInput');
        if (avatarInput.files.length > 0) {
            formData.append('image', avatarInput.files[0]);
        }

        try {
            const response = await fetch('/api/user/update', {
                method: 'POST',
                headers: { 
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',

                },
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                alert('Failed to update profile: ' + (errorData.message || response.statusText));
                return;
            }

            const updatedData = await response.json();

            // Update nilai asli dengan data yang baru
            originalValues.fullname = fullname;
            originalValues.username = username;
            originalValues.phone = phone;
            originalValues.email = email;
            originalValues.password = '';
            originalValues.password_confirmation = '';
            originalImage = document.getElementById('profileImage').src;

            cancelEdit();

            alert('Profile updated successfully!');

        } catch (error) {
            console.error(error);
            alert('An error occurred while updating profile.');
        }
    }
        
        document.getElementById('editBtn').addEventListener('click', enableEdit);
        document.getElementById('cancelBtn').addEventListener('click', cancelEdit);
        document.getElementById('saveBtn').addEventListener('click', function(e) {
            e.preventDefault();
            performUpdate();
        });
        document.getElementById('avatarInput').addEventListener('change', handleImageUpload);
        
        
        function showLogoutConfirm() {
            showConfirmationPopup(); // hanya menampilkan popup
        }

        
        // Initialize on page load
        window.addEventListener('load', function() {
            fetchProfile();
        });
    </script>
</body>
</html>