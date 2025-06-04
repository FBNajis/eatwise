<title>Chatbot - eatwise</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    * {
        font-family: 'Poppins', sans-serif;
    }

    /* Main Content */
    .main-content {
        margin-left: 280px; /* Back to original value that works */
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: #f8f9fa;
        padding-right: 0px; /* Removed right padding to expand to edge */
        position: relative;
    }

    /* Chat Header */
    .chat-header {
        background: #f8f9fa;
        padding: 15px 30px;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        margin: 0px 0px 0 20px;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .chat-avatar {
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        font-weight: bold;
        overflow: hidden;
    }

    .chat-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .chat-info h2 {
        color: #333;
        font-size: 20px;
        font-weight: 600;
    }

    .chat-info p {
        color: #666;
        font-size: 14px;
    }

    /* Chat Container */
    .chat-container {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: white;
        margin: 0 0px 0 20px; /* Removed right margin to expand to edge */
        border-radius: 0;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        max-height: calc(100vh - 200px);
    }

    /* Chat Messages */
    .message-group {
        margin-bottom: 20px;
        clear: both;
    }

    .message-timestamp {
        text-align: center;
        margin-bottom: 15px;
    }

    .timestamp-text {
        background: rgba(0,0,0,0.05);
        color: #666;
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 12px;
        display: inline-block;
        font-weight: 400;
    }

    /* Message Container */
    .message-container {
        display: flex;
        margin-bottom: 8px;
        align-items: flex-end;
        gap: 8px;
        clear: both;
    }

    .message-container.bot {
        justify-content: flex-start;
    }

    .message-container.user {
        justify-content: flex-end;
    }

    /* Message Bubble */
    .message {
        max-width: 70%;
        min-width: 60px;
        padding: 12px 16px;
        border-radius: 20px;
        word-wrap: break-word;
        position: relative;
        display: inline-block;
        font-size: 14px;
        line-height: 1.4;
    }

    /* Bot Message */
    .message.bot {
        background: #ffffff;
        color: #333;
        border-radius: 20px 20px 20px 5px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #f0f0f0;
    }

    /* User Message */
    .message.user {
        background: #e53e3e;
        color: white;
        border-radius: 20px 20px 5px 20px;
        box-shadow: 0 2px 8px rgba(229, 62, 62, 0.2);
    }

    /* Message Content */
    .message-content {
        margin: 0;
        word-break: break-word;
    }

    /* Avatar for bot messages */
    .message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        font-weight: 600;
        flex-shrink: 0;
        border: 2px solid #e0e0e0;
        overflow: hidden;
    }

    .message-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* User message container - simplified */
    .user-message-container {
        margin-bottom: 20px;
        clear: both;
    }

    .user-message-timestamp {
        text-align: center;
        margin-bottom: 15px;
    }

    .user-info {
        color: #666;
        font-size: 12px;
        margin-bottom: 8px;
        text-align: right;
    }

    /* Chat Input */
    .chat-input-container {
        background: white;
        padding: 15px 30px;
        border-top: 1px solid #e0e0e0;
        margin: 0 0px 0px 0px; /* Removed right margin to expand to edge */
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        position: sticky;
        bottom: 0;
        z-index: 10;
    }

    .chat-input-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8f9fa;
        border-radius: 25px;
        padding: 12px 20px;
        border: 2px solid #e0e0e0;
        transition: border-color 0.3s ease;
    }

    .chat-input-wrapper:focus-within {
        border-color: #e53e3e;
    }

    .chat-input {
        flex: 1;
        border: none;
        background: transparent;
        outline: none;
        font-size: 14px;
        color: #333;
    }

    .chat-input::placeholder {
        color: #aaa;
    }

    .send-button {
        background: #e53e3e;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .send-button:hover {
        background: #d32f2f;
        transform: scale(1.05);
    }

    .send-button svg {
        width: 16px;
        height: 16px;
        fill: white;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0; /* Back to original for mobile */
            padding-right: 0;
        }

        .chat-container {
            padding: 20px 15px;
            margin: 0 10px;
        }
        
        .message {
            max-width: 280px;
        }

        .chat-header {
            padding: 12px 20px;
            margin: 10px 10px 0 10px;
        }

        .chat-input-container {
            padding: 12px 20px;
            margin: 0 10px 10px 10px;
        }
    }

    /* Tablet Responsive */
    @media (max-width: 1024px) and (min-width: 769px) {
        .main-content {
            margin-left: 280px; /* Back to original */
        }
    }

    /* Loading animation for bot messages */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message.bot {
        animation: fadeInUp 0.3s ease;
    }

    /* Ensure proper spacing and no overlap */
    .chat-wrapper {
        width: 100%;
        max-width: calc(100vw - 300px); /* Back to original value */
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    @media (max-width: 768px) {
        .chat-wrapper {
            max-width: 100vw; /* Back to original for mobile */
        }
    }
</style>

@include('components.sidebar')                                                                  

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <div class="chat-wrapper">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-avatar">
                <img src="{{ asset('images/catbotprofile.png') }}" alt="Chatbot">
            </div>
            <div class="chat-info">
                <h2>Chatbot</h2>
                <p>Support Agent</p>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="chat-container" id="chatContainer">
            <!-- Initial Welcome Messages -->
            <div class="message-group">
                <div class="message-timestamp">
                    <span class="timestamp-text">Livechat 02:10 PM</span>
                </div>
                
                <div class="message-container bot">
                    <div class="message-avatar">
                        <img src="{{ asset('images/chatbot.png') }}" alt="Chatbot">
                    </div>
                    <div class="message bot">
                        <div class="message-content">Hello Nice</div>
                    </div>
                </div>
                
                <div class="message-container bot">
                    <div class="message-avatar">
                        <img src="{{ asset('images/chatbot.png') }}" alt="Chatbot">
                    </div>
                    <div class="message bot">
                        <div class="message-content">
                            Welcome to LiveChat<br>
                            I was made with Pick a topic from the list or type down a question!
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Welcome Message -->
            <div class="message-group">
                <div class="message-timestamp">
                    <span class="timestamp-text">Livechat 02:10 PM</span>
                </div>
                
                <div class="message-container bot">
                    <div class="message-avatar">
                        <img src="{{ asset('images/chatbot.png') }}" alt="Chatbot">
                    </div>
                    <div class="message bot">
                        <div class="message-content">
                            Welcome to<br>
                            eatwise 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input-container">
            <div class="chat-input-wrapper">
                <input type="text" class="chat-input" placeholder="Type your message..." id="messageInput" />
                <button class="send-button" id="sendButton">
                    <svg viewBox="0 0 24 24">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendButton = document.getElementById('sendButton');
    const messageInput = document.getElementById('messageInput');
    const chatContainer = document.getElementById('chatContainer');

    async function sendToChatbotAPI(userMessage) {
        try {
            const response = await fetch('/api/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: userMessage })
            });

            const data = await response.json();

            if (response.ok && data.choices && data.choices.length > 0) {
                return data.choices[0].message.content;
            } else {
                console.error('API Error:', data);
                return "Sorry, the chatbot failed to respond.";
            }
        } catch (error) {
            console.error('Network Error:', error);
            return "Sorry, there was a problem connecting to the chatbot.";
        }
    }



    
    // Send message functionality
    function sendMessage() {
        const message = messageInput.value.trim();
        if (message) {
            const currentTime = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            // Create user message element with consistent structure
            const userMessageContainer = document.createElement('div');
            userMessageContainer.className = 'user-message-container';
            
            userMessageContainer.innerHTML = `
                <div class="user-message-timestamp">
                    <span class="timestamp-text">Visitor ${currentTime}</span>
                </div>
                <div class="message-container user">
                    <div class="message user">
                        <div class="message-content">${message}</div>
                    </div>
                </div>
            `;
            
            chatContainer.appendChild(userMessageContainer);
            messageInput.value = '';
            
            chatContainer.scrollTop = chatContainer.scrollHeight;
            
            setTimeout(async () => {
                const botReply = await sendToChatbotAPI(message);

                const botMessageGroup = document.createElement('div');
                botMessageGroup.className = 'message-group';
                botMessageGroup.innerHTML = `
                    <div class="message-timestamp">
                        <span class="timestamp-text">Livechat ${currentTime}</span>
                    </div>
                    <div class="message-container bot">
                        <div class="message-avatar">
                            <img src="{{ asset('images/chatbot.png') }}" alt="Chatbot">
                        </div>
                        <div class="message bot">
                            <div class="message-content">${botReply}</div>
                        </div>
                    </div>
                `;
                chatContainer.appendChild(botMessageGroup);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }, 1000);

        }
    }

    // Send button click
    sendButton.addEventListener('click', sendMessage);

    // Enter key press
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Auto-scroll to bottom on page load
    chatContainer.scrollTop = chatContainer.scrollHeight;
});
</script>