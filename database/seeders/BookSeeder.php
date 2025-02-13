<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            ['title' => 'Чистый код', 'author' => 'Роберт Мартин', 'published' => '2008'],
            ['title' => 'Программист-фанатик', 'author' => 'Чад Фа Fowler', 'published' => '2011'],
            ['title' => 'Грокаем алгоритмы', 'author' => 'Адитья Бхаргава', 'published' => '2017'],
            ['title' => 'Внутреннее устройство Linux', 'author' => 'Майкл Керрик', 'published' => '2007'],
            ['title' => 'Совершенный код', 'author' => 'Стив Макконнелл', 'published' => '1993'],
            ['title' => 'Рефакторинг', 'author' => 'Мартин Фаулер', 'published' => '1999'],
            ['title' => 'Код: Тайный язык информатики', 'author' => 'Чарльз Петцольд', 'published' => '1999'],
            ['title' => 'Архитектура корпоративных программных приложений', 'author' => 'Мартин Фаулер', 'published' => '2002'],
            ['title' => 'Программирование. Принципы и практика с использованием C++', 'author' => 'Бьёрн Страуструп', 'published' => '2009'],
            ['title' => 'Основы алгоритмов', 'author' => 'Томас Кормен', 'published' => '1990'],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
