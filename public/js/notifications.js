toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

const SwalConfig = {
    confirmButtonText: 'Ya, Lanjutkan',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#dc3545',
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    }
};

function showSuccessToast(message) {
    toastr.success(message, 'Berhasil');
}

function showErrorToast(message) {
    toastr.error(message, 'Gagal');
}

function showInfoToast(message) {
    toastr.info(message, 'Info');
}

function showWarningToast(message) {
    toastr.warning(message, 'Peringatan');
}

function showConfirmApprove(message, callback) {
    Swal.fire({
        title: 'Konfirmasi Persetujuan',
        text: message || 'Apakah Anda yakin ingin menyetujui ini?',
        icon: 'question',
        showCancelButton: true,
        ...SwalConfig
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

function showConfirmReject(message, callback) {
    Swal.fire({
        title: 'Konfirmasi Penolakan',
        text: message || 'Apakah Anda yakin ingin menolak ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

function showConfirmDelete(message, callback) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: message || 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

function showSuccessAlert(message, callback) {
    Swal.fire({
        title: 'Berhasil!',
        text: message || 'Operasi berhasil dilakukan.',
        icon: 'success',
        confirmButtonColor: '#28a745',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-success'
        }
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
}

function showErrorAlert(message, callback) {
    Swal.fire({
        title: 'Gagal!',
        text: message || 'Terjadi kesalahan. Silakan coba lagi.',
        icon: 'error',
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-danger'
        }
    }).then((result) => {
        if (result.isConfirmed && callback) {
            callback();
        }
    });
}

// Check for flash messages and display them
document.addEventListener('DOMContentLoaded', function () {
    // Check for PHP session flash messages (from hidden divs)
    const successElement = document.querySelector('.alert-success');
    const errorElement = document.querySelector('.alert-error');
    const warningElement = document.querySelector('.alert-warning');
    const infoElement = document.querySelector('.alert-info');

    let successShown = false;
    let errorShown = false;
    let warningShown = false;
    let infoShown = false;

    if (successElement) {
        const message = successElement.textContent || successElement.innerText;
        if (message.trim()) {
            showSuccessToast(message.trim());
            successShown = true;
        }
        successElement.remove();
    }

    if (errorElement) {
        const message = errorElement.textContent || errorElement.innerText;
        if (message.trim()) {
            showErrorToast(message.trim());
            errorShown = true;
        }
        errorElement.remove();
    }

    if (warningElement) {
        const message = warningElement.textContent || warningElement.innerText;
        if (message.trim()) {
            showWarningToast(message.trim());
            warningShown = true;
        }
        warningElement.remove();
    }

    if (infoElement) {
        const message = infoElement.textContent || infoElement.innerText;
        if (message.trim()) {
            showInfoToast(message.trim());
            infoShown = true;
        }
        infoElement.remove();
    }

    // If no PHP flash messages were shown, check sessionStorage (for AJAX requests)
    if (!successShown) {
        const successMessage = sessionStorage.getItem('success_message');
        if (successMessage) {
            showSuccessToast(successMessage);
            sessionStorage.removeItem('success_message');
        }
    }

    if (!errorShown) {
        const errorMessage = sessionStorage.getItem('error_message');
        if (errorMessage) {
            showErrorToast(errorMessage);
            sessionStorage.removeItem('error_message');
        }
    }

    if (!warningShown) {
        const warningMessage = sessionStorage.getItem('warning_message');
        if (warningMessage) {
            showWarningToast(warningMessage);
            sessionStorage.removeItem('warning_message');
        }
    }

    if (!infoShown) {
        const infoMessage = sessionStorage.getItem('info_message');
        if (infoMessage) {
            showInfoToast(infoMessage);
            sessionStorage.removeItem('info_message');
        }
    }
});