@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header">Entrar</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{ old('email') }}" required autofocus>
                                <div class="invalid-feedback">
                                    {!! $errors->first('email', ':message') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" name="password" required>
                                <div class="invalid-feedback">
                                    {!! $errors->first('password', ':message') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Entrar
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
