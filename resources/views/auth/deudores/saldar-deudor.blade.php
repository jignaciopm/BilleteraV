@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6">
        	@if(session()->has("success-saldar-deudor"))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				  <strong>Listo!</strong> Se ha registrado el movimiento. <a href="{{ route('home') }}">VER</a>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			@endif
            <a class="btn btn-danger" href="{{ route('home') }}">Volver</a>

            <div class="card" style="margin-top: 20px">
                <div class="card-header">Saldar Deudor</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('saldar-deudor-post', $deudor["id"]) }}" class="needs-validation" novalidate>
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input id="fecha" type="text" class="form-control" name="fecha" value="{{ now()->format('Y-m-d') }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="concepto">Concepto</label>
                            <input id="concepto" type="text" class="form-control" name="concepto" value="{{ "Pago de ".$deudor["deudor"]." por ".$deudor["concepto"] }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="monto" >Monto</label>
                            <input id="monto" type="number" class="form-control" name="monto" value="{{ $deudor["monto"] }}" readonly>
                        </div>

                        <div class="form-group">
                        	<div class="custom-control custom-radio custom-control-inline">
							  	<input type="radio" id="customRadioInline1" name="tipo" class="custom-control-input" value="+" checked>
							  	<label class="custom-control-label" for="customRadioInline1"><small>INGRESO</small> (+)</label>
							</div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline3" name="medio" class="custom-control-input" value="efectivo">
                                <label class="custom-control-label" for="customRadioInline3">Efectivo</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline4" name="medio" class="custom-control-input" value="transferencia">
                                <label class="custom-control-label" for="customRadioInline4">Transferencia</label>
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
