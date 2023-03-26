@extends('layouts.layout')
@section('content')

<div class="container">
    <h3 class="text-center">Indicadores</h3>
    <div class="text-xl-end text-center">
    <button type="button" class="btn btn-primary mb-4 mt-4 " data-bs-toggle="modal" data-bs-target="#addIndicatorModal">
        Crear Indicador
    </button>
    </div>

    <table class="table table-responsive-sm table-striped table-bordered shadow-lg mt-4" style="width:100%" id="indicators">

        <thead class="thead">
            <tr>
                <th>Nombre indicador</th>
                <th>Codigo Indicador</th>
                <th>Unidad de medida</th>
                <th>Valor indicador</th>
                <th>Fecha indicador</th>
                <th>Tiempo indicador</th>
                <th>Origen indicador</th>
                <td>Accion</td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <br/>

    <h3 class="text-center mt-4">Grafica</h3>
    <div class="mt-3 container text-center">
        <form id="form_range_dates">
            @csrf
            <label for="date_a">Desde</label>
            <input type="date" name="date_a" id="date_a" required>
            <label for="date_a">Hasta</label>
            <input type="date" name="date_b" id="date_b" required>
            <button type="submit" class="btn btn-primary m-3">Filtrar</button>
        </form>
        <canvas id="myChart"></canvas>
    </div>
    </div>
</div>

@include('indicators.modal')
@section('js')

<!-- Script Grafico -->
<script type="text/javascript">
$(document).ready(function(){
    const currency = new Intl.NumberFormat('es-CL', {
            style: 'currency',
            currency: 'CLP',
            minimumFractionDigits: 0
        });
        const graphValues = @json($graphValues);
        let lineChart = null;

        const loadGraph = (data) => {
            const labels = data.map(el => el.fecha_indicador);
            const values = data.map(el => el.valor_indicador);
            const ctx = document.getElementById('myChart').getContext('2d');

            if (lineChart !== null) lineChart.destroy();

            lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        label: 'Valor UF($)',
                        fill: true,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    legend: {
                        position: 'top'
                    },
                    scales: {
                        x: {
                            stacked: false
                        },
                        y: {
                            stacked: false,
                            ticks: {
                                callback: function(value, index, values) {
                                    return currency.format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += currency.format(context.parsed.y)
                                    return label;
                                }
                            }
                        }
                    }
                }

            });
        }


        loadGraph(graphValues);

        $("#form_range_dates").on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{route('indicators.graph.values')}}",
                data: $(this).serialize(),
                success: (data) => {
                    loadGraph(data.graphValues);
                }
            })
        });
});
</script>

<!-- Script Indicador -->
<script type="text/javascript">
$(document).ready(function () {

//Cargar datatable
const table = $('#indicators').DataTable({
    language: {
    "decimal": "",
    "emptyTable": "No hay información",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar _MENU_ Entradas",
    "loadingRecords": "Cargando...",
    "processing": "Procesando...",
    "search": "Buscar:",
    "zeroRecords": "Sin resultados encontrados",
    "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
    }
    },
    "lengthMenu":[[5,10,50,-1],[5,10,50,"Todo"]],
    responsive:true,
    autoWidth:false,
    'order': [[4, 'desc']],
    // searching: false,
    ajax: "{{ url('getIndicators') }}",
    columns: [
        {"data": "nombre_indicador"},
        {"data": "codigo_indicador"},
        {"data": "unidad_medida_indicador"},
        {"data": "valor_indicador"},
        {"data": "fecha_indicador"},
        {
            "data": "tiempo_indicador",
            defaultContent: 'Sin registro'
        },
        {"data": "origen_indicador"},
        {
            "data": null,
            render: function (data, type, row){
                return `<button data-id="${row.id}" class="btn btn-info editIcon" data-bs-toggle="modal" data-bs-target="#editIndicatorModal" ><i class="fa fa-edit"></i></button>
                <button data-id="${row.id}" class="btn btn-danger deleteIcon"><i class="fa fa-trash"></i></button>
                `
            }
        }

    ]
});

//Mostrar datos en modal editar
$(document).on('click','.editIcon',function(){
    $.ajax({
        url: "{{ url('edit') }}",
        type: "post",
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}',
            id: $(this).data('id')
        },
        success: function(response){
            console.log(response);
            $('input[name="indicator_id"]').val(response.data.id);
            $('input[name="edit_nombre"]').val(response.data.nombre_indicador);
            $('input[name="edit_codigo"]').val(response.data.codigo_indicador);
            $('input[name="edit_unidadMedida"]').val(response.data.unidad_medida_indicador);
            $('input[name="edit_valor"]').val(response.data.valor_indicador);
            $('input[name="edit_fecha"]').val(response.data.fecha_indicador);
            $('input[name="edit_tiempo"]').val(response.data.tiempo_indicador);
            $('input[name="edit_origen"]').val(response.data.origen_indicador);

        }
    });
});

//Update Indicator
$('#edit_indicator').submit(function(e){
    e.preventDefault();
    const fd = new FormData(this);
    $('#update_indicator_btn').text('Actualizando...');
    $.ajax({
        url: '{{ route('indicators.update')}}',
        method: 'post',
        data: fd,
        cache: false,
        processData: false,
        contentType: false,
        success: function(res){
            if(res.status == 400){
                    $('#updateForm_errList').html("");
                    $.each(res.errors, function (key,err_values){
                        $('#updateForm_errList').append(`<li>`+err_values+`</li>`);
                    });
                }else{
                    Swal.fire(
                    'Actualizado!',
                    'Indicador actualizado exitosamente',
                    'success'
                )

                $('#updateForm_errList').html("");
                $("#update_indicator_btn").text('Actualizar Empleado');
                $("#edit_indicator")[0].reset();
                table.ajax.reload();
                $("#editIndicatorModal").modal('hide');
                }
        }
    });
});

//Delete indicador
$(document).on('click','.deleteIcon',function(e){
    e.preventDefault();
    Swal.fire({
    title: 'Estas seguro?',
    text: "No podras revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: '{{ url('destroy')}}',
            method: 'post',
            dataType: 'json',
            data: {
                id: $(this).data('id'),
                _token: '{{ csrf_token() }}'
            },
            success:function(res){
                if(res.status == 200){
                Swal.fire(
                    'Eliminado!',
                    'Indicador eliminado exitosamente.',
                    'success'
                )
                table.ajax.reload();
            }
            }
        });


    }
    });
});


// agregar nuevo indicador
$("#add_indicator").submit(function(e){
    e.preventDefault();
    const fd = new FormData(this);
    $("#add_indicator_btn").text("Adding....");
    $.ajax({
        url: '{{ route('indicators.store') }}',
        method: 'post',
        data: fd,
        cache: false,
        processData: false,
        contentType: false,
        order: [0,'desc'],
        success:function(res){
            if(res.status == 400){
                $('#saveForm_errList').html("");
                $.each(res.errors, function (key,err_values){
                    $('#saveForm_errList').append(`<li>`+err_values+`</li>`);
                });
            }else
            {
                Swal.fire(
                    'Agregado!',
                    'Indicator agregado exitosamente!',
                    'success'
                )

                $('#saveForm_errList').html("");
                $('#add_indicator_btn').text('Agregar');
                $('#indicators')[0].reset;
                table.ajax.reload();
                $('#addIndicatorModal').modal('hide');
            }


        }
    });
});


});

</script>

@endsection
@endsection
