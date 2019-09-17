@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
        	@if(session()->has("success-registrar-movimiento"))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				  <strong>Listo!</strong> Se ha registrado el movimiento. <a href="{{ route('home') }}">VER</a>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			@endif

            <a class="btn btn-danger" href="{{ route('home') }}">Volver</a>

            <div class="card" style="margin-top: 20px">
                <div class="card-header">Registrar Movimiento</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('modificar-movimiento-post', $movimiento["id"]) }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input id="fecha" type="text" class="form-control {{$errors->has('fecha') ? 'is-invalid' : ''}}" name="fecha" value="{{ $errors->has('fecha') ? old('fecha') : date("d/m/Y", strtotime($movimiento["fecha"])) }}" required readonly>
                            <div class="invalid-feedback">
						        {!! $errors->first('fecha', ':message') !!}
						    </div>
                        </div>

                        <div class="form-group">
                            <label for="concepto">Concepto</label>
                            <input id="concepto" type="text" class="form-control {{$errors->has('concepto') ? 'is-invalid' : ''}}" name="concepto" value="{{ $errors->has('concepto') ? old('concepto') : $movimiento["concepto"] }}" required readonly>
                            <div class="invalid-feedback">
						        {!! $errors->first('concepto', ':message') !!}
						    </div>
                        </div>
                        
                        @if($movimiento["medio"] == "transferencia")
                            <div class="form-group">
                                <label for="banco">Banco</label>
                                <input id="banco" type="text" class="form-control {{$errors->has('banco') ? 'is-invalid' : ''}}" name="concepto" value="{{ $errors->has('banco') ? old('banco') : $movimiento["banco"] }}" required readonly>
                                <div class="invalid-feedback">
                                    {!! $errors->first('banco', ':message') !!}
                                </div>
                            </div>
                        @endif

                        @if($movimiento["tipo"] == "-")
                            <div class="form-group">
                                <label for="gasto">Gasto</label>
                                <input id="gasto" type="text" class="form-control {{$errors->has('gasto') ? 'is-invalid' : ''}}" name="concepto" value="{{ $errors->has('gasto') ? old('gasto') : $movimiento["gasto"] }}" required readonly>
                                <div class="invalid-feedback">
                                    {!! $errors->first('gasto', ':message') !!}
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="monto" >Monto</label>
                            <input id="monto" type="number" class="form-control {{$errors->has('monto') ? 'is-invalid' : ''}}" name="monto" value="{{ $errors->has('monto') ? old('monto') : $movimiento["monto"] }}" required readonly>
                            <div class="invalid-feedback">
						        {!! $errors->first('monto', ':message') !!}
						    </div>
                        </div>

                        <div class="form-group">
                            @if($movimiento["tipo"] == "+")
                            	<div class="custom-control custom-radio custom-control-inline">
    							  	<input type="radio" id="customRadioInline1" name="tipo" class="custom-control-input" value="+" checked>
    							  	<label class="custom-control-label" for="customRadioInline1">
                                        <span class="badge badge-light">
                                            <span class="fas fa-plus"></span>
                                        </span>
                                        Ingreso                       
                                    </label>
    							</div>
                            @else
    							<div class="custom-control custom-radio custom-control-inline">
    							  	<input type="radio" id="customRadioInline2" name="tipo" class="custom-control-input" value="-" checked>
    							  	<label class="custom-control-label" for="customRadioInline2">
                                        <span class="badge badge-light">
                                            <span class="fas fa-minus"></span>
                                        </span>
                                        Egreso                       
                                    </label>
    							</div>
                            @endif
                        </div>

                        <div class="form-group">
                            @if($movimiento["medio"] == "efectivo")
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline3" name="medio" class="custom-control-input" value="efectivo" checked>
                                    <label class="custom-control-label" for="customRadioInline3">
                                        <span class="badge badge-light">
                                            <span class="fas fa-money-bill"></span>
                                        </span>
                                        Efectivo
                                    </label>
                                </div>
                            @elseif($movimiento["medio"] == "transferencia")
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline4" name="medio" class="custom-control-input" value="transferencia" checked>
                                    <label class="custom-control-label" for="customRadioInline4">
                                        <span class="badge badge-light">
                                            <span class="fas fa-exchange-alt"></span>
                                        </span>
                                        Transferencia
                                    </label>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
