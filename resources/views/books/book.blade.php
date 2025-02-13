<div class="book" 
        data-id="{{ $book->id }}"
        data-title="{{ $book->title }}"
        data-author="{{ $book->author }}"
        data-published="{{ $book->published }}"
    >
    <div class="cover">
        @if ($book->image)
        <img src="{{ asset('storage') }}/{{ $book->image }}" alt="">
        @else
        <div class="placeholder"></div>
        @endif
    </div>
    <div class="content">
        <div class="title">
            <h3>{{ $book->title }}</h3>
        </div>
        <div class="author">
            <strong>Автор:</strong> {{ $book->author }}
        </div>
        <div class="published">
            <strong>Год издания:</strong> {{ $book->published }}
        </div>  
    </div>
    <div class="actions">
        <button class="btn-edit">Ред.</button>
        <button class="btn-delete">Удалить</button>
    </div>
</div>