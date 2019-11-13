<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Спортиные Штаные', 'children' => [
                ['name' => 'Красные'],
                ['name' => 'Жёлтые'],
                ['name' => 'С Лампасами'],
            ]],
            ['name' => 'Прыгучие Мячи'],
            ['name' => 'Геометрические Фигуры', 'children' => [
                ['name' => 'Фигуры о Четырёх Углах', 'children' => [
                    ['name' => 'Кврадраты'],
                    ['name' => 'Ромбы']
                ]],
                ['name' => 'Круги'],
            ]],
            ['name' => 'Товары для Бани', 'children' => [
                ['name' => 'Квас'],
                ['name' => 'Смешные Банные Шапки'],
                ['name' => 'Пахучие Масла', 'children' => [
                    ['name' => 'Запах Ели'],
                    ['name' => 'Запах Яблочек'],
                ]],
            ]]
        ];

        \App\Models\Category::buildTree($categories);
    }
}
