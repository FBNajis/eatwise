<!-- components/sidebar.blade.php -->
<nav class="sidebar" id="sidebar">
    <div class="logo">
        eatwise
    </div>
    
    <a href="{{ route('homepage') }}" class="menu-item explore {{ request()->routeIs('homepage') ? 'active' : '' }}">
        <img src="{{ asset('images/explore_red.png') }}" alt="Explore" class="icon-red">
        <img src="{{ asset('images/explore_white.png') }}" alt="Explore" class="icon-white">
        <span>Explore</span>
    </a>
    
    <a href="{{ route('recipe') }}" class="menu-item recipe {{ request()->routeIs('recipe') ? 'active' : '' }}">
        <img src="{{ asset('images/recipe_red.png') }}" alt="Recipe" class="icon-red">
        <img src="{{ asset('images/recipe_white.png') }}" alt="Recipe" class="icon-white">
        <span>Recipe</span>
    </a>
    
    <a href="{{ route('chatbot') }}" class="menu-item chatbot {{ request()->routeIs('chatbot') ? 'active' : '' }}">
        <img src="{{ asset('images/chatbot_red.png') }}" alt="Chatbot" class="icon-red">
        <img src="{{ asset('images/chatbot_white.png') }}" alt="Chatbot" class="icon-white">
        <span>Chatbot</span>
    </a>
    
    <a href="{{ route('profile') }}" class="menu-item profile {{ request()->routeIs('profile') ? 'active' : '' }}">
        <img src="{{ asset('images/profile_red.png') }}" alt="Profile" class="icon-red">
        <img src="{{ asset('images/profile_white.png') }}" alt="Profile" class="icon-white">
        <span>Profile</span>
    </a>
</nav>

<style>
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

.sidebar.closed {
    transform: translateX(-100%);
}

.logo {
    color: #e53e3e;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 40px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    margin-bottom: 8px;

    border-radius: 25px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
    color: #666;
    text-decoration: none;
    border: 2px solid #CE181B;
    position: relative;
}

.menu-item:hover {
    background: #f7f7f7;
    color: #e53e3e;
    border-color: #e53e3e;
}

.menu-item.active {
    background: #e53e3e;
    color: white;
    border-color: #e53e3e;
}

/* Icon Styles */
.menu-item img {
    width: 30px;
    height: 30px;
    margin-right: 25px;
    transition: opacity 0.3s ease;
}

/* Default state - show red icon */
.menu-item .icon-red {
    opacity: 1;
}

.menu-item .icon-white {
    opacity: 0;
    position: absolute;
    left: 35px; /* Adjust based on padding */
}

/* Hover state - show red icon */
.menu-item:hover .icon-red {
    opacity: 1;
}

.menu-item:hover .icon-white {
    opacity: 0;
}

/* Active state - show white icon */
.menu-item.active .icon-red {
    opacity: 0;
}

.menu-item.active .icon-white {
    opacity: 1;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            sidebar.classList.toggle('closed');
            if (mainContent) {
                mainContent.classList.toggle('expanded');
            }
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && hamburger && !hamburger.contains(event.target)) {
                sidebar.classList.add('closed');
                if (mainContent) {
                    mainContent.classList.add('expanded');
                }
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('closed');
            if (mainContent) {
                mainContent.classList.remove('expanded');
            }
        } else {
            sidebar.classList.add('closed');
            if (mainContent) {
                mainContent.classList.add('expanded');
            }
        }
    });
});
</script>