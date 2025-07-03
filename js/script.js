// Theme toggle functionality
const themeToggle = document.getElementById("theme-toggle");
const body = document.body;
const icon = themeToggle.querySelector("i");

// Check for saved theme preference or use preferred color scheme
const savedTheme =
  localStorage.getItem("theme") ||
  (window.matchMedia("(prefers-color-scheme: dark)").matches
    ? "dark"
    : "light");

// Apply the saved theme
if (savedTheme === "dark") {
  body.classList.add("dark-mode");
  icon.classList.remove("fa-moon");
  icon.classList.add("fa-sun");
}

// Toggle theme
themeToggle.addEventListener("click", () => {
  body.classList.toggle("dark-mode");

  if (body.classList.contains("dark-mode")) {
    icon.classList.remove("fa-moon");
    icon.classList.add("fa-sun");
    localStorage.setItem("theme", "dark");
  } else {
    icon.classList.remove("fa-sun");
    icon.classList.add("fa-moon");
    localStorage.setItem("theme", "light");
  }
});

// Modal functionality
const signupBtn = document.getElementById("signup-btn");
const loginBtn = document.getElementById("login-btn");
const heroSignupBtn = document.getElementById("hero-signup-btn");
const signupModal = document.getElementById("signup-modal");
const loginModal = document.getElementById("login-modal");
const closeModalBtns = document.querySelectorAll(".close-modal");
const switchToLogin = document.getElementById("switch-to-login");
const switchToSignup = document.getElementById("switch-to-signup");

// Show signup modal
const showSignupModal = () => {
  signupModal.style.display = "flex";
  document.body.style.overflow = "hidden";
};

// Show login modal
const showLoginModal = () => {
  loginModal.style.display = "flex";
  document.body.style.overflow = "hidden";
};

// Event listeners
signupBtn.addEventListener("click", showSignupModal);
loginBtn.addEventListener("click", showLoginModal);
heroSignupBtn.addEventListener("click", showSignupModal);

// Close modals
const closeModals = () => {
  signupModal.style.display = "none";
  loginModal.style.display = "none";
  document.body.style.overflow = "auto";
};

closeModalBtns.forEach((btn) => {
  btn.addEventListener("click", closeModals);
});

// Switch between login and signup
switchToLogin.addEventListener("click", (e) => {
  e.preventDefault();
  signupModal.style.display = "none";
  showLoginModal();
});

switchToSignup.addEventListener("click", (e) => {
  e.preventDefault();
  loginModal.style.display = "none";
  showSignupModal();
});

// Close modal when clicking outside
window.addEventListener("click", (e) => {
  if (e.target === signupModal || e.target === loginModal) {
    closeModals();
  }
});

// Password toggle functionality
const togglePassword = document.getElementById("toggle-password");
const passwordInput = document.getElementById("signup-password");
const toggleConfirmPassword = document.getElementById(
  "toggle-confirm-password"
);
const confirmPasswordInput = document.getElementById("signup-confirm-password");
const toggleLoginPassword = document.getElementById("toggle-login-password");
const loginPasswordInput = document.getElementById("login-password");

togglePassword.addEventListener("click", () => {
  const type =
    passwordInput.getAttribute("type") === "password" ? "text" : "password";
  passwordInput.setAttribute("type", type);
  togglePassword.classList.toggle("fa-eye-slash");
});

toggleConfirmPassword.addEventListener("click", () => {
  const type =
    confirmPasswordInput.getAttribute("type") === "password"
      ? "text"
      : "password";
  confirmPasswordInput.setAttribute("type", type);
  toggleConfirmPassword.classList.toggle("fa-eye-slash");
});

toggleLoginPassword.addEventListener("click", () => {
  const type =
    loginPasswordInput.getAttribute("type") === "password"
      ? "text"
      : "password";
  loginPasswordInput.setAttribute("type", type);
  toggleLoginPassword.classList.toggle("fa-eye-slash");
});

// Smooth scrolling for navigation
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    if (this.getAttribute("href") !== "#") {
      e.preventDefault();
      document.querySelector(this.getAttribute("href")).scrollIntoView({
        behavior: "smooth",
      });
    }
  });
});

// Mobile menu functionality
const mobileMenuBtn = document.querySelector(".mobile-menu");
const navLinks = document.querySelector(".nav-links");

mobileMenuBtn.addEventListener("click", () => {
  navLinks.classList.toggle("active");
});

// Close mobile menu when clicking on a link
document.querySelectorAll(".nav-links a").forEach((link) => {
  link.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
      navLinks.classList.remove("active");
    }
  });
});

// Handle window resize
window.addEventListener("resize", () => {
  if (window.innerWidth > 768) {
    navLinks.classList.remove("active");
  }
});

// Enhanced Animated Background
const canvas = document.getElementById("animated-bg");
const ctx = canvas.getContext("2d");

// Set canvas size to full window
function resizeCanvas() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}

window.addEventListener("resize", resizeCanvas);
resizeCanvas();

// Financial elements with more variety
const elements = [];
const colors = [
  "rgba(79, 70, 229, 0.4)", // Primary color
  "rgba(16, 185, 129, 0.4)", // Secondary color
  "rgba(99, 102, 241, 0.4)", // Primary light
  "rgba(67, 56, 202, 0.4)", // Primary dark
  "rgba(239, 68, 68, 0.4)", // Red for alerts
  "rgba(245, 158, 11, 0.4)", // Yellow for warnings
];

// More element types with financial theme
const elementTypes = [
  "bar",
  "pie",
  "line",
  "coin",
  "wallet",
  "graph",
  "percentage",
  "trend",
];

// Create initial elements (more elements for full page)
function initElements() {
  const elementCount = Math.floor(window.innerWidth / 20); // More elements on wider screens

  for (let i = 0; i < elementCount; i++) {
    elements.push({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height,
      size: Math.random() * 20 + 10, // Larger elements
      speed: Math.random() * 1 + 0.5, // Faster movement
      type: elementTypes[Math.floor(Math.random() * elementTypes.length)],
      color: colors[Math.floor(Math.random() * colors.length)],
      rotation: Math.random() * Math.PI * 2,
      rotationSpeed: (Math.random() - 0.5) * 0.03,
      wiggle: Math.random() * 2, // For subtle horizontal movement
      wiggleSpeed: Math.random() * 0.02 + 0.01,
    });
  }
}

// Draw a bar chart element (improved)
function drawBar(ctx, x, y, size, color, rotation, wiggle) {
  ctx.save();
  ctx.translate(x + Math.sin(wiggle) * 5, y);
  ctx.rotate(rotation);

  const barWidth = size * 0.2;
  const barHeights = [
    size * 0.3,
    size * 0.7,
    size * 0.5,
    size * 0.9,
    size * 0.6,
  ];

  const barSpacing = barWidth * 0.3;
  const totalWidth = barWidth * 5 + barSpacing * 4;

  // Draw bars with fill
  for (let i = 0; i < 5; i++) {
    const bx = -totalWidth / 2 + i * (barWidth + barSpacing);
    const bh = -barHeights[i];

    ctx.fillStyle = color.replace("0.4", "0.15");
    ctx.fillRect(bx, size / 2 + bh, barWidth, -bh);

    ctx.beginPath();
    ctx.moveTo(bx, size / 2);
    ctx.lineTo(bx, size / 2 + bh);
    ctx.lineTo(bx + barWidth, size / 2 + bh);
    ctx.lineTo(bx + barWidth, size / 2);
    ctx.closePath();

    ctx.strokeStyle = color;
    ctx.lineWidth = 1.5;
    ctx.stroke();
  }

  ctx.restore();
}

// Draw a pie chart element (improved)
function drawPie(ctx, x, y, size, color, rotation, wiggle) {
  ctx.save();
  ctx.translate(x + Math.sin(wiggle) * 5, y);
  ctx.rotate(rotation);

  const angles = [0.2, 0.3, 0.25, 0.25];
  let startAngle = 0;

  // Draw filled wedges
  for (let i = 0; i < angles.length; i++) {
    const endAngle = startAngle + angles[i] * Math.PI * 2;

    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.arc(0, 0, size / 2, startAngle, endAngle);
    ctx.closePath();

    ctx.fillStyle = color.replace("0.4", "0.15");
    ctx.fill();

    ctx.strokeStyle = color;
    ctx.lineWidth = 1.5;
    ctx.stroke();

    startAngle = endAngle;
  }

  ctx.restore();
}

// Draw a line chart element (improved)
function drawLine(ctx, x, y, size, color, rotation, wiggle) {
  ctx.save();
  ctx.translate(x + Math.sin(wiggle) * 5, y);
  ctx.rotate(rotation);

  const points = 6;
  const segmentWidth = size / (points - 1);
  const path = [];

  ctx.beginPath();
  path.push({ x: -size / 2, y: 0 });
  ctx.moveTo(-size / 2, 0);

  for (let i = 1; i < points; i++) {
    const px = -size / 2 + i * segmentWidth;
    const py = ((Math.random() - 0.5) * size) / 2;
    path.push({ x: px, y: py });
    ctx.lineTo(px, py);
  }

  // Draw area under line
  ctx.lineTo(size / 2, 0);
  ctx.lineTo(-size / 2, 0);
  ctx.closePath();
  ctx.fillStyle = color.replace("0.4", "0.1");
  ctx.fill();

  // Draw line
  ctx.beginPath();
  ctx.moveTo(path[0].x, path[0].y);
  for (let i = 1; i < path.length; i++) {
    ctx.lineTo(path[i].x, path[i].y);
  }
  ctx.strokeStyle = color;
  ctx.lineWidth = 1.5;
  ctx.stroke();

  // Add circles at data points
  for (const point of path) {
    ctx.beginPath();
    ctx.arc(point.x, point.y, 2, 0, Math.PI * 2);
    ctx.fillStyle = color;
    ctx.fill();
  }

  ctx.restore();
}

// Draw a coin/dollar element (improved)
function drawCoin(ctx, x, y, size, color, rotation, wiggle) {
  ctx.save();
  ctx.translate(x + Math.sin(wiggle) * 5, y);
  ctx.rotate(rotation);

  // Outer circle with gradient
  const gradient = ctx.createRadialGradient(0, 0, size / 4, 0, 0, size / 2);
  gradient.addColorStop(0, color.replace("0.4", "0.6"));
  gradient.addColorStop(1, color.replace("0.4", "0.2"));

  ctx.beginPath();
  ctx.arc(0, 0, size / 2, 0, Math.PI * 2);
  ctx.fillStyle = gradient;
  ctx.fill();

  ctx.strokeStyle = color;
  ctx.lineWidth = 1.5;
  ctx.stroke();

  // Dollar sign
  ctx.font = `bold ${size / 2}px Arial`;
  ctx.textAlign = "center";
  ctx.textBaseline = "middle";
  ctx.fillStyle = color.replace("0.4", "0.8");
  ctx.fillText("$", 0, 0);

  ctx.restore();
}

// New element: Wallet
function drawWallet(ctx, x, y, size, color, rotation, wiggle) {
  ctx.save();
  ctx.translate(x + Math.sin(wiggle) * 5, y);
  ctx.rotate(rotation);

  // Wallet body
  ctx.beginPath();
  ctx.roundRect(-size / 2, -size / 3, size, size / 1.5, [size / 4]);
  ctx.fillStyle = color.replace("0.4", "0.15");
  ctx.fill();
  ctx.strokeStyle = color;
  ctx.lineWidth = 1.5;
  ctx.stroke();

  // Wallet flap
  ctx.beginPath();
  ctx.ellipse(0, -size / 3, size / 2, size / 6, 0, 0, Math.PI);
  ctx.stroke();

  // Cards inside
  for (let i = 0; i < 3; i++) {
    ctx.beginPath();
    ctx.roundRect(-size / 2.5, -size / 4 + i * 3, size / 1.25, size / 8, [
      size / 16,
    ]);
    ctx.stroke();
  }

  ctx.restore();
}

// Animation loop
function animate() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  for (let i = 0; i < elements.length; i++) {
    const el = elements[i];

    // Update position
    el.y += el.speed;
    el.rotation += el.rotationSpeed;
    el.wiggle += el.wiggleSpeed;

    // Reset position if off screen
    if (el.y > canvas.height + el.size) {
      el.y = -el.size;
      el.x = Math.random() * canvas.width;
    }

    // Draw element based on type
    switch (el.type) {
      case "bar":
        drawBar(ctx, el.x, el.y, el.size, el.color, el.rotation, el.wiggle);
        break;
      case "pie":
        drawPie(ctx, el.x, el.y, el.size, el.color, el.rotation, el.wiggle);
        break;
      case "line":
        drawLine(ctx, el.x, el.y, el.size, el.color, el.rotation, el.wiggle);
        break;
      case "coin":
        drawCoin(ctx, el.x, el.y, el.size, el.color, el.rotation, el.wiggle);
        break;
      case "wallet":
        drawWallet(ctx, el.x, el.y, el.size, el.color, el.rotation, el.wiggle);
        break;
      // Add cases for other element types if needed
      default:
        drawCoin(ctx, el.x, el.y, el.size, el.color, el.rotation, el.wiggle);
    }
  }

  requestAnimationFrame(animate);
}

// Initialize and start animation
initElements();
animate();

// Auto-dismiss alert after 5 seconds
document.querySelectorAll(".alert").forEach((alert) => {
  setTimeout(() => {
    alert.style.opacity = "0";
    setTimeout(() => alert.remove(), 500);
  }, 5000);
});

// Clean the URL
window.addEventListener("load", () => {
  if (
    window.location.search.includes("message=") ||
    window.location.search.includes("success=")
  ) {
    history.replaceState({}, "", window.location.pathname);
  }
});

