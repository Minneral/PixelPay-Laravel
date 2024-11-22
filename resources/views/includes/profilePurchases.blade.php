<!-- resources/views/pages/profilePurchases.blade.php -->

<div class="body">
    <div class="body__header">
        <p>Предмет:</p>
        <p>Дата:</p>
        <p>Стоимость:</p>
    </div>

    @foreach ($purchases as $item)
        <div class="body__item">
            <div class="body__itemInfo">
                <img src="{{ $item->url }}" alt="icon" />
                <span>{{ $item->item }}</span>
            </div>

            <div class="body__itemDate">
                {{ $item->date }}
            </div>

            <div class="body__itemPrice">
                {{ $item->price }} <span>BYN</span>
            </div>
        </div>
    @endforeach
</div>
