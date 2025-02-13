<dialog>
    <div class="add-book-form">
        <h3>Добавить книгу</h3>

        <form class="form" id="book-form" method="POST" action="/">
            @csrf

            <div class="form-group">
                <label for="title">Название книги<sup>*</sup></label>
            
                <input
                    id="title"
                    name="title"
                    type="text"
                    class="@error('title') is-invalid @else is-valid @enderror"
                />
            </div>

            <div class="form-group">
                <label for="author">Автор<sup>*</sup></label>
            
                <input
                    id="author"
                    name="author"
                    type="text"
                    class="@error('author') is-invalid @else is-valid @enderror"
                />
            </div>

            <div class="form-group">
                <label for="published">Год издания<sup>*</sup></label>
            
                <input
                    id="published"
                    name="published"
                    type="text"
                    class="@error('published') is-invalid @else is-valid @enderror"
                />
            </div>
            
            <div class="form-group">
                <label for="image">Обложка</label>
            
                <input
                    id="image"
                    name="image"
                    type="file"
                    class="@error('paperback') is-invalid @else is-valid @enderror"
                />
            </div>

            <div class="form-group">
                <button type="submit">Сохранить</button>
            </div>
        </form>
    </div>
</dialog>

@push('scripts')
<script>
    const dialog = document.querySelector("dialog");

    dialog.addEventListener('close', () => {
        document.querySelector("dialog form").reset();
    });

    const bookForm = document.getElementById('book-form');
    bookForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);

        for (let [name, value] of formData.entries()) {
            const input = bookForm.querySelector(`[name="${name}"]`);
            let valid = true;
            
            switch(name) {
                case 'title':
                    valid = value.length > 3;
                    break;
                case 'author':
                    valid = value.length > 3;
                    break;
                case 'published':
                    valid = value >= 1200 && value <= 2050;
                    break;
            }

            if (!valid) {
                input.classList.add('is-invalid');
                return false;
            }    
        }

        fetch(e.target.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    })
</script>
@endpush
