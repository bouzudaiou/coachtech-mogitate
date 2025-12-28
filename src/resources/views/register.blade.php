@extends('layouts.app')

@section('content')
    <div class="register-container">
        <h1 class="page-title">商品登録</h1>

        <form action="/products/register" method="POST" enctype="multipart/form-data" class="register-form">
            @csrf

            {{-- 商品名 --}}
            <div class="form__group">
                <label class="form__label">
                    商品名
                    <span class="form__label-required">必須</span>
                </label>
                <input type="text" name="name" class="form__input" value="{{ old('name') }}" placeholder="商品名を入力">
                @error('name')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 値段 --}}
            <div class="form__group">
                <label class="form__label">
                    値段
                    <span class="form__label-required">必須</span>
                </label>
                <input type="number" name="price" class="form__input" value="{{ old('price') }}" placeholder="値段を入力">
                @error('price')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 商品画像 --}}
            <div class="form__group">
                <label class="form__label">
                    商品画像
                    <span class="form__label-required">必須</span>
                </label>
                <div class="form__file-section">
                    <label class="file-input__label">
                        <span class="file-input__button">ファイルを選択</span>
                        <input type="file" name="image" class="file-input__input" accept=".png,.jpeg,.jpg" onchange="previewFile(this)">
                    </label>
                </div>
                @error('image')
                <p class="form__error">{{ $message }}</p>
                @enderror
                <div class="form__image-preview" id="image-preview-wrapper" style="display: none;">
                    <img src="" alt="プレビュー" class="form__image-preview-img" id="preview-image">
                </div>
            </div>

            {{-- 季節 --}}
            <div class="form__group">
                <label class="form__label">
                    季節
                    <span class="form__label-required">必須</span>
                    <span class="form__label-note">複数選択可</span>
                </label>
                <div class="form__checkbox-group">
                    @foreach($seasons as $season)
                        <label class="form__checkbox-label">
                            <input type="checkbox" name="season_ids[]" value="{{ $season->id }}"
                                {{ is_array(old('season_ids')) && in_array($season->id, old('season_ids')) ? 'checked' : '' }}>
                            <span class="form__checkbox-text">{{ $season->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('season_ids')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 商品説明 --}}
            <div class="form__group">
                <label class="form__label">
                    商品説明
                    <span class="form__label-required">必須</span>
                </label>
                <textarea name="description" class="form__textarea" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                @error('description')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- ボタン --}}
            <div class="register-form__buttons">
                <a href="/products" class="button button--back">戻る</a>
                <button type="submit" class="button button--submit">登録</button>
            </div>
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
                    document.getElementById('image-preview-wrapper').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
