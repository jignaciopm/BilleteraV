@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-9">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Movimientos</div>
                    <a href="{{ route('registrar-movimiento') }}" class="btn btn-primary">
                        <span class="fas fa-plus"></span>
                    </a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <table id="movimientos" class="table table-hover dt-responsive nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-center" data-priority="0" data-orderable="false"></th>
                                    <th class="text-center" data-priority="1">Fecha</th>
                                    <th class="text-center" data-priority="4">Concepto</th>
                                    <th class="text-center" data-priority="5">Gasto</th>
                                    <th class="text-center" data-priority="6">Medio</th>
                                    <th class="text-center" data-priority="2">Tipo</th>
                                    <th class="text-center" data-priority="3">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!isset($movimientos) || empty($movimientos) || sizeof($movimientos) <= 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No posee movimientos registrados</td>
                                    </tr>
                                @endif
                                @foreach ($movimientos as $movimiento)
                                    <tr style="cursor: pointer;">
                                        <td class="details"></td>

                                        <td class="text-center" data-order="{{$movimiento["fecha"]}}">{{date("d/m/Y", strtotime($movimiento["fecha"]))}}</td>

                                        <td class="text-center">{{$movimiento["concepto"]}}</td>

                                        <td class="text-center">{{$movimiento["gasto"]}}</td>

                                        <td class="text-center">
                                            @if($movimiento["banco"] == "")
                                                <span class="badge badge-light"><span class="fas fa-money-bill"></span> Efectivo</span>
                                            @else
                                                <span class="badge badge-light"><span class="fas fa-exchange-alt"></span> {{$movimiento["banco"]}}</span>
                                            @endif
                                        </td>

                                        <td class="text-center" data-search="{{$movimiento["tipo"]}}" data-order="{{$movimiento["tipo"]}}">
                                            <span class="fas {{$movimiento["tipo"] == "+" ? 'fa-plus' : 'fa-minus'}}"></span>
                                        </td>

                                        <td class="text-center">{{$movimiento["monto"]}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 20px">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>Deudores</div>
                    <a href="{{ route('registrar-deudor') }}" class="btn btn-success">
                        <span class="fas fa-plus"></span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="deudores" class="table">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Deudor</th>
                                    <th>Monto</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!isset($deudores) || empty($deudores) || sizeof($deudores) <= 0)
                                    <tr>
                                        <td colspan="5" class="text-center">No posee deudores registrados</td>
                                    </tr>
                                @endif
                                @foreach ($deudores as $deudor)
                                    <tr>
                                        <td>{{$deudor["concepto"]}}</td>
                                        <td>{{$deudor["deudor"]}}</td>
                                        <td>{{$deudor["monto"]}}</td>
                                        <td><a href="{{ route('saldar-deudor',$deudor["id"]) }}">Saldar</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 20px">
                <div class="card-header">Relacion ingresos/gastos mensuales</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="meses" class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Mes</th>
                                    <th class="text-center">Ingresos</th>
                                    <th class="text-center">Hogar</th>
                                    <th class="text-center">Carro</th>
                                    <th class="text-center">Salida</th>
                                    <th class="text-center">Ayuda</th>
                                    <th class="text-center">Medicinas</th>
                                    <th class="text-center">Otros</th>
                                    <th class="text-center">Disponible (fin de mes)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!isset($movimientosPorMes) || empty($movimientosPorMes) || sizeof($movimientosPorMes) <= 0)
                                    <tr>
                                        <td colspan="9" class="text-center">No posee movimientos registrados</td>
                                    </tr>
                                @else 
                                    @foreach ($movimientosPorMes[now()->format('Y')] as $mes => $movimiento)
                                        <tr>
                                            <td>{{date('F', strtotime('0-'.$mes.'-01'))}}</td>
                                            <td class="text-center">{{$movimiento["ingresos"]}}</td>
                                            <td class="text-center">{{$movimiento["gastosHogar"]}}</td>
                                            <td class="text-center">{{$movimiento["gastosCarro"]}}</td>
                                            <td class="text-center">{{$movimiento["gastosSalida"]}}</td>
                                            <td class="text-center">{{$movimiento["gastosAyuda"]}}</td>
                                            <td class="text-center">{{$movimiento["gastosMedicina"]}}</td>
                                            <td class="text-center">{{$movimiento["otrosGastos"]}}</td>
                                            <td class="text-center">{{$movimiento["disponible"]}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3" id="balance">
            <div class="card">
                <div class="card-header">Mi Balance</div>
                <div class="card-body text-center">
                    <h1>{{$balance}}</h1>
                    <hr>
                    <h5><strong>DISPONIBLE:</strong> {{$disponible}}</h5>
                    <h5>
                        <span class="badge badge-light">
                            <span class="fas fa-money-bill"></span>
                        </span>
                        <small>EFECTIVO:</small> {{$efectivo}}
                    </h5>
                    <h5>
                        <span class="badge badge-light">
                            <span class="fas fa-exchange-alt"></span>
                        </span>
                        <small>TRANSFERENCIA:</small> {{$transferencia}}
                    </h5>
                    <hr>
                    @foreach($bancos as $banco => $monto)
                        <h6><small>{{$banco}}:</small> {{$monto}}</h6>
                    @endforeach
                    <hr>
                    <h5><small>DEUDORES:</small> {{$b_deudores}}</h5>
                </div>
            </div>

            <div class="card" style="margin-top: 20px">
                <div class="card-header">Balance Conjunto</div>
                <div class="card-body text-center">
                    <h1>{{$b_conjunto['disponible']}}</h1>
                    <hr>
                    <h5>
                        <span class="badge badge-light">
                            <span class="fas fa-money-bill"></span>
                        </span>
                        <small>EFECTIVO:</small> {{$b_conjunto['efectivo']}}
                    </h5>
                    <h5>
                        <span class="badge badge-light">
                            <span class="fas fa-exchange-alt"></span>
                        </span>
                        <small>TRANSFERENCIA:</small> {{$b_conjunto['transferencia']}}
                    </h5>
                    <hr>
                    @foreach($bancos as $banco => $monto)
                        <h6><small>{{$banco}}:</small> {{$b_conjunto['bancos'][$banco]}}</h6>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var table = $('#movimientos').DataTable({
            columnDefs: [ {
                className: 'control',
                orderable: false,
                targets:   0
            } ],
            "order": [[ 0, "desc" ]],
            responsive: {
                details: {
                    /*display: $.fn.dataTable.Responsive.display.modal( {
                        header: function ( row ) {
                            var data = row.data();
                            console.log(data);
                            return 'Detalles de '+data[2];
                        }
                    } ),*/
                    type: 'column',
                    /*renderer: $.fn.dataTable.Responsive.renderer.tableAll()*/
                },
                breakpoints: [
		            { name: 'desktop', width: Infinity },
		            { name: 'tablet',  width: 1024 },
		            { name: 'fablet',  width: 768 },
		            { name: 'phone',   width: 480 }
		        ]
            }
        });
    </script>
@endsection
