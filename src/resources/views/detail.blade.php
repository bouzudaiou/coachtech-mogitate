
@extends('layouts.app')

@section('content')
    <div class="detail-container">
        {{-- パンくずリスト --}}
        <div class="breadcrumb">
            <a href="/products" class="breadcrumb__link">商品一覧</a>
            <span class="breadcrumb__separator">></span>
            <span class="breadcrumb__current">{{ $product->name }}</span>
        </div>

        {{-- 商品詳細・更新フォーム --}}
        <form action="/products/{{ $product->id }}/update" method="POST" enctype="multipart/form-data" class="detail-form">
            @csrf
            @method('PATCH')

            <div class="detail-form__content">
                {{-- 左側：画像と商品説明 --}}
                <div class="detail-form__left">
                    {{-- 画像 --}}
                    <div class="detail-form__image-wrapper">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="detail-form__image" id="preview-image">
                    </div>

                    {{-- ファイル選択 --}}
                    <div class="detail-form__file-input">
                        <label class="file-input__label">
                            <span class="file-input__button">ファイルを選択</span>
                            <input type="file" name="image" class="file-input__input" accept=".png,.jpeg,.jpg" onchange="previewFile(this)">
                        </label>
                        <span class="file-input__name" id="file-name">{{ basename($product->image) }}</span>
                    </div>
                    @error('image')
                    <p class="form__error">{{ $message }}</p>
                    @enderror

                    {{-- 商品説明 --}}
                    <div class="form__group form__group--description">
                        <label class="form__label">商品説明</label>
                        <textarea name="description" class="form__textarea">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- 右側：フォーム --}}
                <div class="detail-form__right">
                    {{-- 商品名 --}}
                    <div class="form__group">
                        <label class="form__label">商品名</label>
                        <input type="text" name="name" class="form__input" value="{{ old('name', $product->name) }}">
                        @error('name')
                        <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 値段 --}}
                    <div class="form__group">
                        <label class="form__label">値段</label>
                        <input type="number" name="price" class="form__input" value="{{ old('price', $product->price) }}">
                        @error('price')
                        <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 季節 --}}
                    <div class="form__group">
                        <label class="form__label">季節</label>
                        <div class="form__checkbox-group">
                            @foreach($seasons as $season)
                                <label class="form__checkbox-label">
                                    <input type="checkbox" name="season_ids[]" value="{{ $season->id }}"
                                        {{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
                                    <span class="form__checkbox-text">{{ $season->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('season_ids')
                        <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ボタン --}}
            <div class="detail-form__buttons">
                <a href="/products" class="button button--back">戻る</a>
                <button type="submit" class="button button--submit">変更を保存</button>
                <button type="button" class="button button--delete" onclick="document.getElementById('delete-form').submit()">🗑</button>
            </div>
        </form>

        {{-- 削除用の別フォーム --}}
        <form action="/products/{{ $product->id }}/delete" method="POST" id="delete-form" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        // 画像プレビュー機能
        function previewFile(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(file);
                document.getElementById('file-name').textContent = file.name;
            }
        }
    </script>
@endsection
