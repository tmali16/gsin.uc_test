@extends('layouts.app')
@section('content')
<div class="container h-100">
    <div class="row  h-100 justify-content-center" >
        <div class="col-md-8 h-100 d-flex justify-content-center align-items-center">
            <div class="d-flex align-items-center">
                <div class="card border-0 shadow " style="width: 40em">
                    <div class="card-header">{{ __('Установка нового пороля') }}</div>
                    <div class="card-body bg-light">
                        <form method="POST" action="{{ route('password') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Новый пароль') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Повторите пароль') }}</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Сохранить') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection