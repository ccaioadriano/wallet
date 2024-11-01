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
                                    <h3 class="card-text text-success">{{Auth::user()->getSaldoFormatado()}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-muted">Despesas</h6>
                                    <h4 class="text-danger">R$ 3,200.00</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-muted">Ganhos</h6>
                                    <h4 class="text-success">R$ 8,200.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>
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
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Script do Gráfico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');
    const expenseChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Alimentação', 'Transporte', 'Lazer', 'Educação', 'Outros'],
            datasets: [{
                label: 'Despesas',
                data: [25, 20, 15, 30, 10], // Dados de exemplo
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                ],
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
</script>
@endsection