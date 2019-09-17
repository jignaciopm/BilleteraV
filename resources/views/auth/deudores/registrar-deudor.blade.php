@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
        	@if(session()->has("success-registrar-deudor"))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				  <strong>Listo!</strong> Se ha registrado el deudor. <a href="{{ route('home') }}">VER</a>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			@endif
            <a class="btn btn-danger" href="{{ route('home') }}">Volver</a>

            <div class="card" style="margin-top: 20px">
                <div class="card-header">Registrar Deudor</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registrar-deudor-post') }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="deudor">Deudor</label>
                            <input id="deudor" type="text" class="form-control {{$errors->has('deudor') ? 'is-invalid' : ''}}" name="deudor" value="{{ old('deudor') }}" required>
                            <div class="invalid-feedback">
                                {!! $errors->first('deudor', ':message') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="concepto">Concepto</label>
                            <input id="concepto" type="text" class="form-control {{$errors->has('concepto') ? 'is-invalid' : ''}}" name="concepto" value="{{ old('concepto') }}" required>
                            <div class="invalid-feedback">
						        {!! $errors->first('concepto', ':message') !!}
						    </div>
                        </div>

                        <div class="form-group">
                            <label for="monto" >Monto</label>
                            <input id="monto" type="number" class="form-control {{$errors->has('monto') ? 'is-invalid' : ''}}" name="monto" value="{{ old('monto') }}" required>
                            <div class="invalid-feedback">
						        {!! $errors->first('monto', ':message') !!}
						    </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Registrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
