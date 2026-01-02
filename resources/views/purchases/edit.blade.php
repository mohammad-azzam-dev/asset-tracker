@extends('layouts.app')

@section('title', 'Edit Purchase')
@section('header', 'Edit Purchase')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Purchase Details</h3>
            </div>
            <form action="{{ route('purchases.update', $purchase) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="stock_type">Metal Type</label>
                        <select name="stock_type" id="stock_type" class="form-control @error('stock_type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="gold" {{ old('stock_type', $purchase->stock_type) === 'gold' ? 'selected' : '' }}>Gold</option>
                            <option value="silver" {{ old('stock_type', $purchase->stock_type) === 'silver' ? 'selected' : '' }}>Silver</option>
                        </select>
                        @error('stock_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="purchase_price">Purchase Price (per unit)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step="0.01" name="purchase_price" id="purchase_price"
                                   class="form-control @error('purchase_price') is-invalid @enderror"
                                   value="{{ old('purchase_price', $purchase->purchase_price) }}" required>
                            @error('purchase_price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" step="0.0001" name="quantity" id="quantity"
                               class="form-control @error('quantity') is-invalid @enderror"
                               value="{{ old('quantity', $purchase->quantity) }}" required>
                        @error('quantity')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" required>
                            <option value="oz" {{ old('unit', $purchase->unit) === 'oz' ? 'selected' : '' }}>Ounces (oz)</option>
                            <option value="gram" {{ old('unit', $purchase->unit) === 'gram' ? 'selected' : '' }}>Grams</option>
                            <option value="kg" {{ old('unit', $purchase->unit) === 'kg' ? 'selected' : '' }}>Kilograms</option>
                        </select>
                        @error('unit')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="purchase_date">Purchase Date</label>
                        <input type="date" name="purchase_date" id="purchase_date"
                               class="form-control @error('purchase_date') is-invalid @enderror"
                               value="{{ old('purchase_date', $purchase->purchase_date?->format('Y-m-d')) }}">
                        @error('purchase_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes (optional)</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $purchase->notes) }}</textarea>
                        @error('notes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Purchase</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
