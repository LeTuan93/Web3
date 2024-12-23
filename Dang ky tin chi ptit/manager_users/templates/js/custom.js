// // Custom js

function showSection(sectionId, element) {
    // Ẩn tất cả các section
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.style.display = 'none');

    // Hiển thị section đã chọn
    document.getElementById(sectionId).style.display = 'block';

    // Lưu sections mà block vào localStorage
    localStorage.setItem('currentTab', sectionId);

    // Đổi lại tất cả các mũi tên thành mũi tên phải và bỏ màu sắc
    const listItems = document.querySelectorAll('.list-group-item');
    listItems.forEach(item => {
        item.classList.remove('active');
        item.querySelector('i').classList.replace('fa-angle-down', 'fa-angle-right'); // Đổi mũi tên sang phải
        item.style.backgroundColor = ''; // Bỏ màu nền
        item.style.color = ''; // Bỏ màu chữ
    });

    // Đặt lại mũi tên của mục đang chọn thành mũi tên xuống và thay đổi màu sắc
    element.classList.add('active');
    element.querySelector('i').classList.replace('fa-angle-right', 'fa-angle-down'); // Đổi mũi tên sang xuống
    element.style.backgroundColor = '#d72323'; // Màu nền cho mục được chọn
    element.style.color = 'white'; // Màu chữ cho mục được chọn
}

// Hiển thị tab được lưu khi tải lại trang
document.addEventListener('DOMContentLoaded', () => {
    const savedTab = localStorage.getItem('currentTab') || 'regyster_internship'; // Mặc định là "Đăng ký thực tập"
    const sectionElement = document.querySelector(`.list-group-item[onclick="showSection('${savedTab}', this)"]`);
    if (sectionElement) {
        showSection(savedTab, sectionElement);
    } else {
        const firstItem = document.querySelector('.list-group-item');
        showSection('regyster_internship', firstItem);
    }
});



document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.toggle-preference');
    const preferenceOrders = document.querySelectorAll('.preference-order');
    const hiddenInput = document.getElementById('preferences-hidden');
    const submitButton = document.getElementById('submit-preferences');

    // Quản lý danh sách nguyện vọng
    const selectedPreferences = [];

    // Cập nhật thứ tự nguyện vọng
    function updatePreferenceOrders() {
        selectedPreferences.forEach((companyId, index) => {
            //template strings
            const orderCell = document.querySelector(`.preference-order[data-company-id="${companyId}"]`);
            if (orderCell) {
                orderCell.textContent = index + 1;
            }
        });

        // Làm trống các ô không được chọn
        // cell = <td>
        // dataset là một đối tượng chứa tất cả các thuộc tính data-*
        // cell.dataset.companyId  = companyId
        preferenceOrders.forEach(cell => {
            if (!selectedPreferences.includes(cell.dataset.companyId)) {
                cell.textContent = '--';
            }
        });

        // Kích hoạt nút submit nếu đủ 3 nguyện vọng
        submitButton.disabled = selectedPreferences.length !== 3;

        // Cập nhật giá trị cho hidden input
        hiddenInput.value = JSON.stringify(
            selectedPreferences.map((companyId, index) => ({
                priority_order: index + 1,
                company_id: companyId
            }))
        );
    }

    // Lắng nghe sự kiện tick checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            // this = checkbox, dataset.companyId = companyId
            const companyId = this.dataset.companyId;

            if (this.checked) {
                if (selectedPreferences.length < 3) {
                    selectedPreferences.push(companyId);
                } else {
                    alert('Chỉ được chọn tối đa 3 nguyện vọng.');
                    this.checked = false;
                }
            } else { // checkbox bị bỏ chọn
                // Tìm vị trí của companyId trong mảng selectedPreferences
                const index = selectedPreferences.indexOf(companyId);
                if (index > -1) {
                    // Xóa companyId khỏi mảng selectedPreferences
                    selectedPreferences.splice(index, 1);
                }
            }

            updatePreferenceOrders();
        });
    });
});


// Hàm hiển thị popup xác nhận khi duyệt
document.addEventListener('DOMContentLoaded', function () {
    function showModal(id) {
        const confirmUrl = '?module=home&action=dashboard&approve_id=' + id + '&confirm_approve=yes';
        const confirmButton = document.getElementById('confirmApproveBtn');
        if (confirmButton) {
            confirmButton.href = confirmUrl;
        }
        var myModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        myModal.show();
    }
});




