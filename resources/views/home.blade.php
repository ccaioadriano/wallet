@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Resumo Financeiro</h2>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-muted">Saldo Total</h5>
                                    <h3 @class([
    'text-danger' => Auth::user()->getSaldo() < 0,
    'text-success' => Auth::user()->getSaldo() > 0
])>{{Auth::user()->getSaldoFormatado()}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-muted">Despesas</h6>
                                    <h4 class="text-danger">{{Auth::user()->getTotalDespesa()}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-muted">Ganhos</h6>
                                    <h4 class="text-success">{{Auth::user()->getTotalReceita()}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->transacoes()->where("tipo", "despesa")->sum('valor') > 0)
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted text-center">Distribuição de Despesas</h6>
                                        <canvas id="expenseChart" width="400" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Script do Gráfico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{ route('recupera-informacao-grafico') }}", // URL da rota
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF
            },
            success: function (response) {

                const labels = Object.keys(response); // Nomes das categorias
                const data = labels.map(label => response[label].total); // Totais de cada categoria
                const colors = labels.map(label => response[label].color); // Cores de cada categoria

                const ctx = document.getElementById('expenseChart');

                if (ctx) {
                    ctx.getContext('2d');
                    const expenseChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels, // chaves retornadas do back
                            datasets: [{
                                label: 'Despesas',
                                data: data,
                                backgroundColor: colors,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: (tooltipItem) => `${tooltipItem.label}: R$ ${tooltipItem.raw}`
                                    }
                                }
                            }
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição:', error);
            }
        });
    });
</script>
@endsection