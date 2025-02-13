@extends('layout')

@section('books')
    @if (count($books) > 0)
    <div class="pagination-box">
    {{ $books->links() }}
    </div>
    <div class="book-list" id="book-list">
        @foreach ($books as $book)
            @include('books.book')
        @endforeach  
    </div>
    @endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('book-list').addEventListener('click', function(event) {

            if (event.target && event.target.className === 'btn-delete') {
                const bookId = event.target.closest('.book').dataset.id;
                fetch('/books/' + bookId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }

            if (event.target && event.target.className === 'btn-edit') {
                const dialog = document.querySelector("dialog");
                const data = event.target.closest('.book').dataset;

                for (const [key, value] of Object.entries(data)) {
                    const field = dialog.querySelector(`[name="${key}"]`);
                    if (field) {
                        field.value = value;
                    }
                }

                dialog.querySelector('form').action = '/books/' + data.id;
                dialog.querySelector('h3').textContent = 'Редактировать книгу';

                dialog.showModal();
            }
        });
    });
</script>
@endpush