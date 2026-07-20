class AjaxTable {
    constructor(options) {
        this.url = options.url;
        this.container = options.container ?? "table-content";
        this.keyword = options.keyword ?? null;
        this.filters = options.filters ?? [];
        this.init();
    }

    load(url = null) {
        let requestUrl = new URL(url ?? this.url, window.location.origin);
        if (this.keyword) {
            const keyword = document.getElementById(this.keyword);
            if (keyword) {
                requestUrl.searchParams.set("keyword", keyword.value);
            }
        }
        this.filters.forEach(filter => {
            const id = typeof filter === "string"
                ? filter
                : filter.name;
            const param = typeof filter === "string"
                ? filter
                : filter.param;
            const el = document.getElementById(id);
            if (el) {
                if (el.value !== "") {
                    requestUrl.searchParams.set(param, el.value);
                } else {
                    requestUrl.searchParams.delete(param);
                }
            }
        });
        // Preserve perPage if set
        const perPageSelect = document.getElementById('perPage');
        if (perPageSelect && perPageSelect.value) {
            requestUrl.searchParams.set("perPage", perPageSelect.value);
        }
        fetch(requestUrl.toString(), {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
            .then(res => res.text())
            .then(html => {
                document.getElementById(this.container).innerHTML = html;
                this.attachButtonListeners();
            });
    }

    init() {
        document.addEventListener("DOMContentLoaded", () => {
            this.load();
        });
        if (this.keyword) {
            document.getElementById(this.keyword)?.addEventListener("keyup", () => {
                this.load();
            });
        }
        this.filters.forEach(filter => {
            const id = typeof filter === "string"
                ? filter
                : filter.name;
            document.getElementById(id)?.addEventListener("change", () => {
                this.load();
            });
        });
        // Handle perPage change
        document.getElementById('perPage')?.addEventListener("change", () => {
            this.load();
        });
        document.addEventListener("click", (e) => {
            const link = e.target.closest(".compact-pagination a");
            if (!link) return;
            e.preventDefault();
            this.load(link.href);
        });
    }
    attachButtonListeners() {
        const container = document.getElementById(this.container);
        if (!container) return;
        const deleteButtons = container.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const nama = this.getAttribute('data-nama') || '';
                const message = nama
                    ? 'Apakah Anda yakin ingin menghapus ' + nama + '? Tindakan ini tidak dapat dibatalkan!'
                    : (this.getAttribute('data-message') || 'Apakah Anda yakin ingin menghapus data ini?');
                const url = this.getAttribute('href');

                if (typeof showConfirmDelete === 'function') {
                    showConfirmDelete(message, function () {
                        window.location.href = url;
                    });
                } else {
                    window.location.href = url;
                }
            });
        });

        // Handle approve button clicks with SweetAlert2
        const approveButtons = container.querySelectorAll('.approve-btn');
        approveButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin menyetujui ini?';
                const url = this.getAttribute('href');

                if (typeof showConfirmApprove === 'function') {
                    showConfirmApprove(message, function () {
                        window.location.href = url;
                    });
                } else {
                    window.location.href = url;
                }
            });
        });

        // Handle reject button clicks with SweetAlert2
        const rejectButtons = container.querySelectorAll('.reject-btn');
        rejectButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin menolak ini?';
                const url = this.getAttribute('href');

                if (typeof showConfirmReject === 'function') {
                    showConfirmReject(message, function () {
                        window.location.href = url;
                    });
                } else {
                    window.location.href = url;
                }
            });
        });

        // Handle toggle status button clicks with SweetAlert2
        const toggleButtons = container.querySelectorAll('.toggle-status-btn');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const nama = this.getAttribute('data-nama') || '';
                const status = this.getAttribute('data-status');
                const isNonaktif = status === 'nonaktif';
                const title = isNonaktif ? 'Nonaktifkan Pengguna' : 'Aktifkan Pengguna';
                const message = 'Apakah Anda yakin ingin ' + (isNonaktif ? 'menonaktifkan' : 'mengaktifkan') + ' pengguna ' + nama + '?';
                const icon = isNonaktif ? 'warning' : 'question';
                const url = this.getAttribute('href');

                Swal.fire({
                    title: title,
                    text: message,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonText: isNonaktif ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: isNonaktif ? '#dc3545' : '#28a745',
                    cancelButtonColor: '#6c757d',
                    customClass: {
                        confirmButton: isNonaktif ? 'btn btn-danger' : 'btn btn-success',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    }

}