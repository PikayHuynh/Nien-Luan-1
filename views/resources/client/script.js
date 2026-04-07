// Hàm validate rỗng
const isEmpty = value => !value || value.trim() === "";

// Validate username: tối thiểu 3 ký tự, không ký tự đặc biệt
const validateUsername = username => /^[A-Za-z0-9_]{3,}$/.test(username);

// Validate password: tối thiểu 6 ký tự
const validatePassword = pw => pw.length >= 6;

// Show lỗi ngay dưới input
const showError = (input, message) => {
    const old = input.parentNode.querySelector(".text-error");
    if (old) old.remove();

    const error = document.createElement("div");
    error.className = "text-error text-danger mt-1";
    error.innerText = message;

    input.parentNode.appendChild(error);
};

// Xóa lỗi
const clearError = input => {
    const old = input.parentNode.querySelector(".text-error");
    if (old) old.remove();
};

// ===============================
//  REGISTER VALIDATION
// ===============================
document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.querySelector("form[action*='register']");
    if (registerForm) {
        registerForm.addEventListener("submit", e => {
            const username = registerForm.querySelector("input[name='name']");
            const password = registerForm.querySelector(
                "input[name='password']"
            );
            const confirmPw = registerForm.querySelector(
                "input[name='confirm_password']"
            );
            let valid = true;

            // Clear lỗi cũ
            [username, password, confirmPw].forEach(clearError);

            // Validate username
            if (isEmpty(username.value)) {
                showError(username, "Username không được để trống.");
                valid = false;
            } else if (!validateUsername(username.value)) {
                showError(
                    username,
                    "Username phải từ 3 ký tự, không dấu, không ký tự đặc biệt."
                );
                valid = false;
            }

            // Validate password
            if (isEmpty(password.value)) {
                showError(password, "Mật khẩu không được để trống.");
                valid = false;
            } else if (!validatePassword(password.value)) {
                showError(password, "Mật khẩu phải từ 6 ký tự trở lên.");
                valid = false;
            }

            // Validate confirm password
            if (password.value !== confirmPw.value) {
                showError(confirmPw, "Sai mật khẩu.");
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    // ===============================
    //  LOGIN VALIDATION
    // ===============================
    const loginForm = document.querySelector("form[action*='login']");
    if (loginForm) {
        loginForm.addEventListener("submit", e => {
            const username = loginForm.querySelector("input[name='TEN_KH']");
            const password = loginForm.querySelector("input[name='MATKHAU']");
            let valid = true;

            [username, password].forEach(clearError);

            if (isEmpty(username.value)) {
                showError(username, "Vui lòng nhập username.");
                valid = false;
            }

            if (isEmpty(password.value)) {
                showError(password, "Vui lòng nhập mật khẩu.");
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    const searchInput = document.getElementById("searchInput");
    const searchForm = document.getElementById("searchForm");
    let searchTimeout;

    // Chỉ chạy nếu cả hai phần tử tồn tại
    if (searchInput && searchForm) {
        searchInput.addEventListener("input", function () {
            // Xóa timeout trước đó nếu có
            clearTimeout(searchTimeout);

            // Nếu ít nhất 1 ký tự thì tìm kiếm
            if (this.value.trim().length >= 1) {
                // Đặt một delay nhỏ (500ms) để tránh gửi quá nhiều request khi user đang gõ
                searchTimeout = setTimeout(function () {
                    searchForm.submit();
                }, 1000);
            }
        });
    }

    // ===============================
    //  PREMIUM CARD INTERACTIONS
    // ===============================
    const premiumCards = document.querySelectorAll(".product-card, .category-tile");

    premiumCards.forEach(card => {
        card.addEventListener("mousemove", e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;

            card.style.transform = `perspective(1000px) translateY(-15px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
            
            // Update shadow based on mouse position
            card.style.boxShadow = `${-rotateY * 2}px ${rotateX * 2}px 50px rgba(0,0,0,0.5)`;
        });

        card.addEventListener("mouseleave", () => {
            card.style.transform = "";
            card.style.boxShadow = "";
        });
    });

    // ===============================
    //  SCROLL REVEAL ANIMATIONS
    // ===============================
    const revealElements = document.querySelectorAll(".reveal");

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
                // Optional: Stop observing after reveal
                // revealObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1, // Trigger when 10% of the element is visible
        rootMargin: "0px 0px -50px 0px" // Trigger slightly before it hits the viewport
    });

    revealElements.forEach(el => revealObserver.observe(el));
});



