<div class="logo">
    <a href="/"><h1>НОБ</h1></a>
</div>
<div class="search">
    <input id="search" type="text" placeholder="Поиск" value="{{ request('search') }}">
</div>
<div class="action">
    <button class="outline" id="add-book">Добавить книгу</button>
</div>

@push('scripts')
<script>
    document.getElementById('add-book').addEventListener('click', () => {
        const dialog = document.querySelector("dialog");
        dialog.showModal();
    });

    document.getElementById('search').addEventListener('input', () => {
        const value = document.getElementById('search').value;
        if (value.length >= 3) {
            location.href = `/?search=${value}`;
        }
    })
</script>    
@endpush