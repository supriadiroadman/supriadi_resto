{{-- Dipanggil di form create.blade.php dan edit.blade.php --}}
@error($name)
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror