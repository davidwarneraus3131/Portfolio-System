<footer class="bg-gradient-to-r from-[#3b5757] to-[#020d1b] text-white py-8 mt-10 relative shadow-custom">
  <div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
      
      <!-- Left side: Logo or company name -->
      <div class="text-lg font-semibold">
        © 2024 TeckSpiral
      </div>

      <!-- Middle section: Navigation links -->
      <div class="mt-6 text-center text-sm text-gray-300">
        All rights reserved | Made with ❤️ by TeckSpiral
      </div>

      <!-- Right side: Social media icons -->
      <div class="flex space-x-4">
        <a href="https://facebook.com" class="text-gray-300 hover:text-white" aria-label="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://twitter.com" class="text-gray-300 hover:text-white" aria-label="Twitter">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="https://instagram.com" class="text-gray-300 hover:text-white" aria-label="Instagram">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://linkedin.com" class="text-gray-300 hover:text-white" aria-label="LinkedIn">
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="https://wa.me/6379162739" class="text-gray-300 hover:text-white" aria-label="WhatsApp" target="_blank">
          <i class="fab fa-whatsapp"></i>
        </a>
      </div>
      
    </div>
  </div>
</footer>

<!-- Font Awesome for social icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<style>
  /* Custom top-only shadow */
  .shadow-custom {
    box-shadow: 0 -5px 10px rgba(0, 0, 0, 0.2);
  }
</style>

<!-- Live Chat -->

<div class="fixed bottom-6 right-6">
  <button id="chatIcon" class="bg-green-600 text-white p-4 rounded-full shadow-lg hover:bg-green-700">
    <i class="fas fa-comment-dots text-xl"></i>
  </button>
</div>

<!-- Chat Box -->
<div id="chatBox" class="fixed bottom-20 right-6 bg-white w-96 h-[70-vh] flex flex-col shadow-lg rounded-lg hidden">


  <!-- Header -->
  <div class="bg-green-600 text-white px-4 py-3 flex items-center justify-between rounded-t-lg">
    <div class="flex items-center">
      <div class="w-10 h-10 bg-gray-200 rounded-full mr-3"></div>
      <h3 class="text-lg font-semibold">Sridhar</h3>
    </div>
    <button id="closeChatBox" class="text-white hover:text-gray-200">
      <i class="fas fa-times"></i>
    </button>
  </div>

  <!-- Chat Messages -->
  <div id="chatMessages" class="flex-1 overflow-y-auto p-4 bg-gray-100 space-y-3 h-full">

    <!-- Example Messages -->
    <!-- Received Message -->
    <div class="flex items-start">
      <div class="bg-gray-200 text-gray-800 rounded-lg px-4 py-2 max-w-xs">
        Hello! How can I help you?
      </div>
    </div>
    <!-- Sent Message -->
    <div class="flex items-end justify-end">
      <div class="bg-green-500 text-white rounded-lg px-4 py-2 max-w-xs">
        I have a question about my order.
      </div>
    </div>
  </div>

  <!-- Input Area -->
  <div class="bg-white px-4 py-3 border-t border-gray-300 flex items-center">
    <button class="text-gray-500 hover:text-gray-700 mr-2">
      <i class="far fa-smile text-xl"></i>
    </button>
    <input
      type="text"
      id="chatMessageInput"
      class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-gray-800"
      placeholder="Type a message..."
    />
    <button
      id="sendMessage"
      class="ml-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"
    >
      <i class="fas fa-paper-plane"></i>
    </button>
  </div>
</div>


<script>
  const chatIcon = document.getElementById('chatIcon');
  const chatBox = document.getElementById('chatBox');
  const closeChatBox = document.getElementById('closeChatBox');

  chatIcon.addEventListener('click', () => {
    chatBox.classList.toggle('hidden');
  });

  closeChatBox.addEventListener('click', () => {
    chatBox.classList.add('hidden');
  });


  const chatMessages = document.getElementById('chatMessages');
const chatMessageInput = document.getElementById('chatMessageInput');
const sendMessage = document.getElementById('sendMessage');

// Send message
sendMessage.addEventListener('click', () => {
  const message = chatMessageInput.value.trim();
  if (message) {
    fetch('send_message', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
  },
  body: `message=${encodeURIComponent(message)}`
})
.then(response => response.json())
.then(data => {
  if (!data.success) {
    alert(data.message);
  }
});
  }
});

// Load messages
 // Function to load new messages
 function loadMessages() {
  fetch('./fetch_messages')
    .then(response => response.json())
    .then(messages => {
      chatMessages.innerHTML = '';  // Clear existing messages
      messages.forEach(msg => {
        const div = document.createElement('div');
        div.classList.add(msg.sent_by === 'user' ? 'text-right' : 'text-left');
        div.textContent = msg.message;
        chatMessages.appendChild(div);
      });

      // Debugging: Check scrollTop values
      console.log('Before scroll, scrollHeight:', chatMessages.scrollHeight);
      console.log('Before scroll, scrollTop:', chatMessages.scrollTop);

      // Scroll to the bottom
      chatMessages.scrollTop = chatMessages.scrollHeight;

      console.log('After scroll, scrollTop:', chatMessages.scrollTop);
    });
}


  // Load messages every 3 seconds
  setInterval(loadMessages, 3000);



</script>




