{{-- File ini dipanggil di app.blade.php --}}
<script>
    $(document).ready(function () {
        // Init Sweetalert2
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        

        // Toast
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session("success") }}'
            })
        @endif
        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session("error") }}'
            })
        @endif
        @if (session('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ session("warning") }}'
            })
        @endif
        @if (session('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ session("info") }}'
            })
        @endif

        // Alert
        @if (session('alert_success'))
            Swal.fire(
                'Good job!',
                '{{ session("alert_success") }}',
                'success'
            )
        @endif
        @if (session('alert_error'))
            Swal.fire(
                'Oops...',
                '{{ session("alert_error") }}',
                'error'
            )
        @endif
        @if (session('alert_warning'))
            Swal.fire(
                'Oops...',
                '{{ session("alert_warning") }}',
                'warning'
            )
        @endif
        @if (session('alert_info'))
            Swal.fire(
                '',
                '{{ session("alert_info") }}',
                'info'
            )
        @endif

        // Jika ada inputan form yang belum valid
        @if ($errors->any()) {
            Toast.fire({
                icon: 'error',
                title: 'Ada kesalahan, Mohon periksa kembali form inputan'
            })
        }
        @endif

    // Delete Confirm with Sweetalert2
    $(document).on("click", "#delete", function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const name = $(this).data('name');
        Swal.fire({
            title: `Anda Yakin menghapus ${name}?`,
            text: "Kamu tidak dapat mengembalikan data!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    });

    });
</script>