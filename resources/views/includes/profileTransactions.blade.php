<!-- resources/views/pages/profileTransactions.blade.php -->

<div class="body">
    <div class="body__header">
        <p>Действие:</p>
        <p>Дата:</p>
        <p>Сумма:</p>
    </div>

    @foreach ($transactions as $item)
        <div class="body__item">
            <div class="body__itemAction">
                {{ $item->type }}
            </div>

            <div class="body__itemDate">
                {{ $item->date }}
            </div>

            <div class="body__itemPrice">
                {{ $item->value }} <span class="{{ $item->type === 'Вывод' ? 'red' : 'green' }}">BYN</span>
            </div>
        </div>
    @endforeach
</div>
