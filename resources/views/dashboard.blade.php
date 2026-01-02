@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Live Prices Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-line"></i> Live Market Prices</h3>
                <div class="card-tools">
                    <span class="badge badge-info" id="price-update-time">Loading...</span>
                    <button type="button" class="btn btn-tool" id="refresh-prices" title="Refresh Prices">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Gold Price</span>
                                <span class="info-box-number" id="gold-price-oz">Loading...</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description" id="gold-price-gram">per troy ounce</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-secondary">
                            <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Silver Price</span>
                                <span class="info-box-number" id="silver-price-oz">Loading...</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description" id="silver-price-gram">per troy ounce</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Portfolio Summary - Invested -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>${{ number_format($totals['gold'], 2) }}</h3>
                <p>Gold Invested ({{ $counts['gold'] }} purchases)</p>
            </div>
            <div class="icon">
                <i class="fas fa-coins"></i>
            </div>
            <a href="{{ route('purchases.index') }}" class="small-box-footer">View Purchases <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>${{ number_format($totals['silver'], 2) }}</h3>
                <p>Silver Invested ({{ $counts['silver'] }} purchases)</p>
            </div>
            <div class="icon">
                <i class="fas fa-coins"></i>
            </div>
            <a href="{{ route('purchases.index') }}" class="small-box-footer">View Purchases <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>${{ number_format($totals['gold'] + $totals['silver'], 2) }}</h3>
                <p>Total Portfolio Invested</p>
            </div>
            <div class="icon">
                <i class="fas fa-wallet"></i>
            </div>
            <a href="{{ route('purchases.index') }}" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $counts['total'] }}</h3>
                <p>Total Purchases</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#addPurchaseModal">Add New <i class="fas fa-plus-circle"></i></a>
        </div>
    </div>
</div>

<!-- Current Value Cards -->
<div class="row" id="current-value-section" style="display: none;">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3 id="gold-current-value">$0.00</h3>
                <p>Gold Current Value</p>
                <small id="gold-profit-loss" class="text-white"></small>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-gradient-secondary">
            <div class="inner">
                <h3 id="silver-current-value">$0.00</h3>
                <p>Silver Current Value</p>
                <small id="silver-profit-loss" class="text-white"></small>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3 id="total-current-value">$0.00</h3>
                <p>Total Current Value</p>
                <small id="total-profit-loss" class="text-white"></small>
            </div>
            <div class="icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-balance-scale"></i> Holdings Summary</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Metal</th>
                            <th>Quantity (oz)</th>
                            <th>Invested</th>
                            <th>Current Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-warning text-dark">Gold</span></td>
                            <td>{{ number_format($quantities['gold'], 4) }}</td>
                            <td>${{ number_format($totals['gold'], 2) }}</td>
                            <td id="gold-holdings-value">-</td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-secondary">Silver</span></td>
                            <td>{{ number_format($quantities['silver'], 4) }}</td>
                            <td>${{ number_format($totals['silver'], 2) }}</td>
                            <td id="silver-holdings-value">-</td>
                        </tr>
                        <tr class="table-primary">
                            <td><strong>Total</strong></td>
                            <td>-</td>
                            <td><strong>${{ number_format($totals['gold'] + $totals['silver'], 2) }}</strong></td>
                            <td id="total-holdings-value"><strong>-</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list"></i> Recent Purchases</h3>
                <div class="card-tools">
                    <a href="{{ route('purchases.index') }}" class="btn btn-tool">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <tbody>
                        @forelse($purchases->take(5) as $purchase)
                        <tr>
                            <td>
                                @if($purchase->stock_type === 'gold')
                                    <span class="badge bg-warning text-dark">Gold</span>
                                @else
                                    <span class="badge bg-secondary">Silver</span>
                                @endif
                            </td>
                            <td>{{ $purchase->quantity }} {{ $purchase->unit }}</td>
                            <td>${{ number_format($purchase->total_value, 2) }}</td>
                            <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('M d') : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No purchases yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPurchaseModal">
                    <i class="fas fa-plus"></i> Add Purchase
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Purchase Modal -->
<div class="modal fade" id="addPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="addPurchaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="addPurchaseModalLabel"><i class="fas fa-plus-circle"></i> Add New Purchase</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPurchaseForm">
                @csrf
                <div class="modal-body">
                    <div id="modal-errors" class="alert alert-danger" style="display: none;"></div>
                    <div id="modal-success" class="alert alert-success" style="display: none;"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_stock_type">Metal Type <span class="text-danger">*</span></label>
                                <select name="stock_type" id="modal_stock_type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="gold">Gold</option>
                                    <option value="silver">Silver</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_purchase_price">Purchase Price (per unit) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="purchase_price" id="modal_purchase_price" class="form-control" required>
                                </div>
                                <small class="text-muted">Current: Gold $<span id="modal-gold-price">-</span>/oz, Silver $<span id="modal-silver-price">-</span>/oz</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modal_quantity">Quantity <span class="text-danger">*</span></label>
                                <input type="number" step="0.0001" name="quantity" id="modal_quantity" class="form-control" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modal_unit">Unit <span class="text-danger">*</span></label>
                                <select name="unit" id="modal_unit" class="form-control" required>
                                    <option value="oz" selected>Ounces (oz)</option>
                                    <option value="gram">Grams</option>
                                    <option value="kg">Kilograms</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modal_purchase_date">Purchase Date</label>
                                <input type="date" name="purchase_date" id="modal_purchase_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="modal_notes">Notes (optional)</label>
                        <textarea name="notes" id="modal_notes" rows="2" class="form-control" placeholder="e.g., Dealer name, coin type, etc."></textarea>
                    </div>

                    <div class="card bg-light">
                        <div class="card-body py-2">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <small class="text-muted">Total Investment</small>
                                    <h4 id="modal-total-investment">$0.00</h4>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Current Market Value</small>
                                    <h4 id="modal-current-value">$0.00</h4>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Difference</small>
                                    <h4 id="modal-difference">$0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="modal-submit-btn">
                        <i class="fas fa-save"></i> Save Purchase
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let metalPrices = { gold: null, silver: null };
const goldInvested = {{ $totals['gold'] }};
const silverInvested = {{ $totals['silver'] }};
const goldQuantity = {{ $quantities['gold'] }};
const silverQuantity = {{ $quantities['silver'] }};

function formatCurrency(value) {
    return '$' + value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function updatePriceDisplay(prices) {
    if (prices.gold) {
        metalPrices.gold = prices.gold;
        $('#gold-price-oz').text(formatCurrency(prices.gold.price_per_oz));
        $('#gold-price-gram').text(formatCurrency(prices.gold.price_per_gram) + ' per gram');
        $('#modal-gold-price').text(prices.gold.price_per_oz.toFixed(2));
    } else {
        $('#gold-price-oz').text('Unavailable');
        $('#gold-price-gram').text('-');
    }

    if (prices.silver) {
        metalPrices.silver = prices.silver;
        $('#silver-price-oz').text(formatCurrency(prices.silver.price_per_oz));
        $('#silver-price-gram').text(formatCurrency(prices.silver.price_per_gram) + ' per gram');
        $('#modal-silver-price').text(prices.silver.price_per_oz.toFixed(2));
    } else {
        $('#silver-price-oz').text('Unavailable');
        $('#silver-price-gram').text('-');
    }

    if (prices.fetched_at) {
        const date = new Date(prices.fetched_at);
        $('#price-update-time').text('Updated: ' + date.toLocaleTimeString());
    }

    calculateCurrentValues();
    updateModalCalculations();
}

function calculateCurrentValues() {
    if (!metalPrices.gold && !metalPrices.silver) return;

    let goldValue = 0;
    let silverValue = 0;

    if (metalPrices.gold) {
        goldValue = goldQuantity * metalPrices.gold.price_per_oz;
    }
    if (metalPrices.silver) {
        silverValue = silverQuantity * metalPrices.silver.price_per_oz;
    }

    const totalValue = goldValue + silverValue;
    const totalInvested = goldInvested + silverInvested;

    const goldPL = goldValue - goldInvested;
    const silverPL = silverValue - silverInvested;
    const totalPL = totalValue - totalInvested;

    $('#current-value-section').show();
    $('#gold-current-value').text(formatCurrency(goldValue));
    $('#silver-current-value').text(formatCurrency(silverValue));
    $('#total-current-value').text(formatCurrency(totalValue));

    const goldPLPercent = goldInvested > 0 ? ((goldPL / goldInvested) * 100).toFixed(1) : 0;
    const silverPLPercent = silverInvested > 0 ? ((silverPL / silverInvested) * 100).toFixed(1) : 0;
    const totalPLPercent = totalInvested > 0 ? ((totalPL / totalInvested) * 100).toFixed(1) : 0;

    $('#gold-profit-loss').text((goldPL >= 0 ? '+' : '') + formatCurrency(goldPL) + ' (' + goldPLPercent + '%)');
    $('#silver-profit-loss').text((silverPL >= 0 ? '+' : '') + formatCurrency(silverPL) + ' (' + silverPLPercent + '%)');
    $('#total-profit-loss').text((totalPL >= 0 ? '+' : '') + formatCurrency(totalPL) + ' (' + totalPLPercent + '%)');

    $('#gold-holdings-value').text(formatCurrency(goldValue));
    $('#silver-holdings-value').text(formatCurrency(silverValue));
    $('#total-holdings-value').html('<strong>' + formatCurrency(totalValue) + '</strong>');
}

function fetchPrices() {
    $.ajax({
        url: '{{ route("api.prices") }}',
        method: 'GET',
        success: function(data) {
            updatePriceDisplay(data);
        },
        error: function() {
            $('#price-update-time').text('Error loading prices');
        }
    });
}

function refreshPrices() {
    $('#refresh-prices i, #navbar-refresh-prices i').addClass('fa-spin');
    $.ajax({
        url: '{{ route("api.prices.refresh") }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(data) {
            updatePriceDisplay(data);
            $('#refresh-prices i, #navbar-refresh-prices i').removeClass('fa-spin');
        },
        error: function() {
            $('#price-update-time').text('Error refreshing prices');
            $('#refresh-prices i, #navbar-refresh-prices i').removeClass('fa-spin');
        }
    });
}

function updateModalCalculations() {
    const stockType = $('#modal_stock_type').val();
    const price = parseFloat($('#modal_purchase_price').val()) || 0;
    const quantity = parseFloat($('#modal_quantity').val()) || 0;
    const unit = $('#modal_unit').val();

    const totalInvestment = price * quantity;
    $('#modal-total-investment').text(formatCurrency(totalInvestment));

    let quantityInOz = quantity;
    if (unit === 'gram') {
        quantityInOz = quantity / 31.1035;
    } else if (unit === 'kg') {
        quantityInOz = (quantity * 1000) / 31.1035;
    }

    let currentValue = 0;
    if (stockType === 'gold' && metalPrices.gold) {
        currentValue = quantityInOz * metalPrices.gold.price_per_oz;
    } else if (stockType === 'silver' && metalPrices.silver) {
        currentValue = quantityInOz * metalPrices.silver.price_per_oz;
    }

    $('#modal-current-value').text(formatCurrency(currentValue));

    const diff = currentValue - totalInvestment;
    if (diff >= 0) {
        $('#modal-difference').text('+' + formatCurrency(diff)).removeClass('text-danger').addClass('text-success');
    } else {
        $('#modal-difference').text(formatCurrency(diff)).removeClass('text-success').addClass('text-danger');
    }
}

$(document).ready(function() {
    fetchPrices();
    setInterval(fetchPrices, 300000);

    $('#refresh-prices, #navbar-refresh-prices').click(refreshPrices);

    // Modal calculations
    $('#modal_stock_type, #modal_purchase_price, #modal_quantity, #modal_unit').on('change keyup', updateModalCalculations);

    // Auto-fill current price when metal type is selected
    $('#modal_stock_type').on('change', function() {
        const type = $(this).val();
        if (type === 'gold' && metalPrices.gold) {
            $('#modal_purchase_price').val(metalPrices.gold.price_per_oz.toFixed(2));
        } else if (type === 'silver' && metalPrices.silver) {
            $('#modal_purchase_price').val(metalPrices.silver.price_per_oz.toFixed(2));
        }
        updateModalCalculations();
    });

    // Form submission
    $('#addPurchaseForm').on('submit', function(e) {
        e.preventDefault();

        $('#modal-errors').hide();
        $('#modal-success').hide();
        $('#modal-submit-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: '{{ route("purchases.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#modal-success').text('Purchase added successfully! Reloading...').show();
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr) {
                $('#modal-submit-btn').prop('disabled', false).html('<i class="fas fa-save"></i> Save Purchase');

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul class="mb-0">';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#modal-errors').html(errorHtml).show();
                } else {
                    $('#modal-errors').text('An error occurred. Please try again.').show();
                }
            }
        });
    });

    // Reset form when modal is closed
    $('#addPurchaseModal').on('hidden.bs.modal', function() {
        $('#addPurchaseForm')[0].reset();
        $('#modal-errors, #modal-success').hide();
        $('#modal-total-investment, #modal-current-value, #modal-difference').text('$0.00');
        $('#modal-difference').removeClass('text-success text-danger');
        $('#modal_purchase_date').val('{{ date("Y-m-d") }}');
    });
});
</script>
@endpush
