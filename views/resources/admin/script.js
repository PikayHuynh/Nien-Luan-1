document.addEventListener("DOMContentLoaded", () => {
    const adminForms = document.querySelectorAll("form");

    adminForms.forEach(form => {
        form.addEventListener("submit", e => {
            let valid = true;

            // Xóa lỗi cũ
            form.querySelectorAll(".text-error").forEach(el => el.remove());

            // Lặp tất cả input/select/textarea trong form
            form.querySelectorAll("input, select, textarea").forEach(field => {
                const name = field.getAttribute("name");
                if (!name) return;

                const value = field.value.trim();

                // RULE CHUNG

                // Required
                if (field.hasAttribute("required") && value === "") {
                    showError(field, "Trường này không được để trống.");
                    valid = false;
                    return;
                }

                // Kiểm tra độ dài tên
                if (name.toLowerCase().includes("ten") && value !== "") {
                    if (value.length < 3) {
                        showError(field, "Tên phải ít nhất 3 ký tự.");
                        valid = false;
                    }
                }

                // Điện thoại
                if (name === "SODIENTHOAI" && value !== "") {
                    const phoneRegex = /^[0-9]{9,11}$/;
                    if (!phoneRegex.test(value)) {
                        showError(field, "Số điện thoại phải 9–11 chữ số.");
                        valid = false;
                    }
                }

                // Các giá trị số (đơn giá, tổng tiền, thuế, giá mua...)
                if (
                    ["GIATRI", "TONGTIENHANG", "THUE", "GIAMUA"].includes(name)
                ) {
                    if (value !== "" && isNaN(value)) {
                        showError(field, "Giá trị phải là số.");
                        valid = false;
                    }
                    if (value < 0) {
                        showError(field, "Giá trị phải ≥ 0.");
                        valid = false;
                    }
                }

                // Số lượng
                if (name === "SOLUONG" && value !== "") {
                    if (isNaN(value) || value <= 0) {
                        showError(field, "Số lượng phải là số và lớn hơn 0.");
                        valid = false;
                    }
                }

                // Upload ảnh
                if (field.type === "file" && field.files.length > 0) {
                    const file = field.files[0];
                    const allow = [
                        "image/png",
                        "image/jpeg",
                        "image/jpg",
                        "image/webp"
                    ];

                    if (!allow.includes(file.type)) {
                        showError(field, "Chỉ cho phép JPG, PNG, WEBP.");
                        valid = false;
                    }

                    if (file.size > 3 * 1024 * 1024) {
                        showError(field, "Dung lượng ảnh tối đa 3MB.");
                        valid = false;
                    }
                }
            });

            if (!valid) e.preventDefault();
        });
    });

    const searchInput = document.querySelector(".adminSearchInput");
    const searchForm = document.querySelector(".adminSearchForm");
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

// ==============================
// HIỂN THỊ LỖI (ARROW FUNCTION)
// ==============================
const showError = (input, message) => {
    const err = document.createElement("div");
    err.className = "text-error text-danger mt-1";
    err.innerText = message;
    input.insertAdjacentElement("afterend", err);
};
