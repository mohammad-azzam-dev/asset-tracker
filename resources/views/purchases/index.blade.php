@extends('layouts.app')

@section('title', 'My Purchases')
@section('header', 'My Purchases')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Purchases</h3>
                <div class="card-tools">
                    <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Purchase
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Purchase Price</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Total Invested</th>
                            <th>Current Value</th>
                            <th>Profit/Loss</th>
                            <th>Date</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                        <tr data-type="{{ $purchase->stock_type }}" data-quantity="{{ $purchase->quantity }}" data-unit="{{ $purchase->unit }}" data-invested="{{ $purchase->total_value }}">
                            <td>
                                @if($purchase->stock_type === 'gold')
                                    <span class="badge bg-warning text-dark">Gold</span>
                                @else
                                    <span class="badge bg-secondary">Silver</span>
                                @endif
                            </td>
                            <td>${{ number_format($purchase->purchase_price, 2) }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>{{ $purchase->unit }}</td>
                            <td>${{ number_format($purchase->total_value, 2) }}</td>
                            <td class="current-value">-</td>
                            <td class="profit-loss">-</td>
                            <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('M d, Y') : '-' }}</td>
                            <td>{{ Str::limit($purchase->notes, 30) ?: '-' }}</td>
                            <td>
                                <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No purchases yet. <a href="{{ route('purchases.create') }}">Add your first purchase!</a></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let metalPrices = { gold: null, silver: null };

function formatCurrency(value) {
    return '$' + value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function calculateCurrentValues() {
    if (!metalPrices.gold && !metalPrices.silver) return;

    $('tbody tr[data-type]').each(function() {
        const row = $(this);
        const type = row.data('type');
        const quantity = parseFloat(row.data('quantity'));
        const unit = row.data('unit');
        const invested = parseFloat(row.data('invested'));

        let priceData = type === 'gold' ? metalPrices.gold : metalPrices.silver;
        if (!priceData) {
            row.find('.current-value').text('-');
            row.find('.profit-loss').text('-');
            return;
        }

        let quantityInOz = quantity;
        if (unit === 'gram') {
            quantityInOz = quantity / 31.1035;
        } else if (unit === 'kg') {
            quantityInOz = (quantity * 1000) / 31.1035;
        }

        const currentValue = quantityInOz * priceData.price_per_oz;
        const profitLoss = currentValue - invested;
        const profitPercent = invested > 0 ? ((profitLoss / invested) * 100).toFixed(1) : 0;

        row.find('.current-value').text(formatCurrency(currentValue));

        if (profitLoss >= 0) {
            row.find('.profit-loss').html('<span class="text-success">+' + formatCurrency(profitLoss) + ' (' + profitPercent + '%)</span>');
        } else {
            row.find('.profit-loss').html('<span class="text-danger">' + formatCurrency(profitLoss) + ' (' + profitPercent + '%)</span>');
        }
    });
}

function fetchPrices() {
    $.ajax({
        url: '{{ route("api.prices") }}',
        method: 'GET',
        success: function(data) {
            if (data.gold) metalPrices.gold = data.gold;
            if (data.silver) metalPrices.silver = data.silver;
            calculateCurrentValues();
        }
    });
}

$(document).ready(function() {
    fetchPrices();
    setInterval(fetchPrices, 300000);
});
</script>
@endpush
