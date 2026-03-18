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
});
