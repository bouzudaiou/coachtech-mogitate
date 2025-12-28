@extends('layouts.app')

@section('content')
    <div class="products-container">
        {{-- 左サイドバー（検索・並び替え） --}}
        <aside class="sidebar">
            {{-- 検索キーワードがある場合はタイトルを変更 --}}
            @if(request('keyword'))
                <h1 class="page-title">"{{ request('keyword') }}"の商品一覧</h1>
            @else
                <h1 class="page-title">商品一覧</h1>
            @endif

            {{-- 検索フォーム --}}
            <form action="/products" method="GET" class="search-form">
                <input type="text" name="keyword" class="search-form__input" placeholder="商品名で検索" value="{{ request('keyword') }}">
                <button type="submit" class="search-form__button">検索</button>
            </form>

            {{-- 並び替え --}}
            <div class="sort-section">
                <p class="sort-section__label">価格順で表示</p>
                <div class="sort-section__select-wrapper">
                    <select name="sort" class="sort-section__select" onchange="location.href=this.value">
                        <option value="/products{{ request('keyword') ? '?keyword=' . request('keyword') : '' }}">価格で並べ替え</option>
                        <option value="/products?sort=high{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}" {{ request('sort') === 'high' ? 'selected' : '' }}>高い順に表示</option>
                        <option value="/products?sort=low{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}" {{ request('sort') === 'low' ? 'selected' : '' }}>低い順に表示</option>
                    </select>
                </div>
            </div>

            {{-- 検索・並び替え条件のリセット --}}
            @if(request('keyword') || request('sort'))
                <div class="reset-section">
                    <a href="/products" class="reset-section__link">× 条件をリセット</a>
                </div>
            @endif
        </aside>

        {{-- 右側コンテンツ（商品一覧） --}}
        <div class="products-main">
            {{-- 商品追加ボタン --}}
            <div class="products-main__header">
                <a href="/products/register" class="add-button">+ 商品を追加</a>
            </div>

            {{-- 商品カード一覧 --}}
            <div class="products-grid">
                @foreach($products as $product)
                    <a href="/products/detail/{{ $product->id }}" class="product-card">
                        <div class="product-card__image-wrapper">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-card__image">
                        </div>
                        <div class="product-card__info">
                            <p class="product-card__name">{{ $product->name }}</p>
                            <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- ページネーション --}}
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
