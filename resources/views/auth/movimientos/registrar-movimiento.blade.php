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
                        <form method="POST" action="{{ route('registrar-movimiento-post') }}" class="needs-validation" novalidate>
                            {{ csrf_field() }}

                            @if(isset($deudor))
                                <input type="hidden" name="deudor" value="{{$deudor['id']}}">
                            @endif

                            <div class="form-group">
                                <label for="fecha">Fecha</label>
                                <input id="fecha" type="text" class="form-control {{$errors->has('fecha') ? 'is-invalid' : ''}}" name="fecha" value="{{ old('fecha') != null ? old('fecha') : date('Y-m-d',strtotime(now()))}}" required data-toggle="datepicker" autocomplete="false" readonly="">
                                <div class="invalid-feedback">
    						        {!! $errors->first('fecha', ':message') !!}
    						    </div>
                            </div>

                            <div class="form-group">
                                <label for="concepto">Concepto</label>
                                @if(isset($deudor))
                                    <input id="concepto" type="text" class="form-control {{$errors->has('concepto') ? 'is-invalid' : ''}}" name="concepto" value="{{ "Pago de ".$deudor["deudor"]." por ".$deudor["concepto"] }}" required>
                                @else
                                    <input id="concepto" type="text" class="form-control {{$errors->has('concepto') ? 'is-invalid' : ''}}" name="concepto" value="{{ old('concepto') }}" required>
                                @endif
                                <div class="invalid-feedback">
    						        {!! $errors->first('concepto', ':message') !!}
    						    </div>
                            </div>

                            <div class="form-group" id="banco" {{old('banco') != null || $errors->has('banco') ? 'style=display:block' : 'style=display:none'}}>
                                <label for="banco">Banco</label>
                                <select name="banco" class="form-control {{$errors->has('banco') ? 'is-invalid' : ''}}">
                                    <option value="">Seleccionar un banco</option>
                                    <option value="BanPan" {{old('banco') == "BanPan" ? 'selected':''}}>Banesco Panama</option>
                                    <option value="Chase" {{old('banco') == "Chase" ? 'selected':''}}>Chase</option>
                                    <option value="BofA" {{old('banco') == "BofA" ? 'selected':''}}>Bank of America</option>
                                </select>
                                <div class="invalid-feedback">
                                    {!! $errors->first('banco', ':message') !!}
                                </div>
                            </div>

                            <div class="form-group" id="gasto" {{old('gasto') != null || $errors->has('gasto') ? 'style=display:block' : 'style=display:none'}}>
                                <label for="gasto">Gasto</label>
                                <select name="gasto" class="form-control {{$errors->has('gasto') ? 'is-invalid' : ''}}">
                                    <option value="">Seleccionar un gasto</option>
                                    <!-- 'Hogar','Carro', 'Medicinas', 'Ayuda familiar', 'Salida', 'Otros' -->
                                    <option value="Hogar" {{old('gasto') == "Hogar" ? 'selected':''}}>Hogar</option>
                                    <option value="Carro" {{old('gasto') == "Carro" ? 'selected':''}}>Carro</option>
                                    <option value="Medicinas" {{old('gasto') == "Medicinas" ? 'selected':''}}>Medicinas</option>
                                    <option value="Ayuda familiar" {{old('gasto') == "Ayuda familiar" ? 'selected':''}}>Ayuda familiar</option>
                                    <option value="Salida" {{old('gasto') == "Salida" ? 'selected':''}}>Salida</option>
                                    <option value="Comisiones" {{old('gasto') == "Comisiones" ? 'selected':''}}>Comisiones</option>
                                    <option value="Cambios" {{old('gasto') == "Cambios" ? 'selected':''}}>Cambios</option>
                                    <option value="Prestamos" {{old('gasto') == "Prestamos" ? 'selected':''}}>Prestamos</option>
                                    <option value="Otros" {{old('gasto') == "Otros" ? 'selected':''}}>Otros</option>
                                </select>
                                <div class="invalid-feedback">
                                    {!! $errors->first('gasto', ':message') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="monto" >Monto</label>
                                @if(isset($deudor))
                                    <input id="monto" type="number" class="form-control {{$errors->has('monto') ? 'is-invalid' : ''}}" name="monto" value="{{ $deudor["monto"] }}" required>
                                @else
                                    <input id="monto" type="number" class="form-control {{$errors->has('monto') ? 'is-invalid' : ''}}" name="monto" value="{{ old('monto') }}" required>
                                @endif
                                <div class="invalid-feedback">
    						        {!! $errors->first('monto', ':message') !!}
    						    </div>
                            </div>

                            <div class="form-group">
                            	<div class="custom-control custom-radio custom-control-inline">
    							  	<input type="radio" id="customRadioInline1" name="tipo" class="custom-control-input" value="+" {{isset($deudor) ? "checked" : ""}}>
    							  	<label class="custom-control-label" for="customRadioInline1">
                                        <span class="badge badge-light">
                                            <span class="fas fa-plus"></span>
                                        </span>
                                        Ingreso                      
                                    </label>
    							</div>
    							@if(!isset($deudor))
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="tipo" class="custom-control-input" value="-">
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
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline3" name="medio" class="custom-control-input" value="efectivo">
                                    <label class="custom-control-label" for="customRadioInline3">
                                        <span class="badge badge-light">
                                            <span class="fas fa-money-bill"></span>
                                        </span>
                                        Efectivo
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline4" name="medio" class="custom-control-input" value="transferencia">
                                    <label class="custom-control-label" for="customRadioInline4">
                                        <span class="badge badge-light">
                                            <span class="fas fa-exchange-alt"></span>
                                        </span>
                                        Transferencia
                                    </label>
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

@section('script')
    <script>
        $(document).ready(function() {
            $("input[name=tipo]").click(function(){
                var tipo = $(this);
                var tipoVal = tipo.val();
                
                if(tipoVal == "-")
                    $("#gasto").show();
                else
                    $("#gasto").hide();
            });

            $("input[name=medio]").click(function(){
                var tipo = $(this);
                var tipoVal = tipo.val();
                
                if(tipoVal == "transferencia")
                    $("#banco").show();
                else
                    $("#banco").hide();
            });
        });
    </script>
@endsection