@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<style>
    .page-header {
        animation: slideInDown 0.5s ease-out;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1rem;
    }

    .page-header h2 {
        font-weight: 700;
        font-size: 1.75rem;
        color: #212529;
        margin: 0;
    }

    .product-table-wrapper {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 0.5rem;
        transition: transform 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.15);
    }

    .stock-badge-low {
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .action-buttons .btn-outline-primary,
    .action-buttons .btn-outline-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        padding: 0;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .action-buttons .btn-outline-primary:hover,
    .action-buttons .btn-outline-danger:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header .btn {
            width: 100%;
        }

        .product-table-wrapper {
            margin-bottom: 2rem;
        }
    }
</style>

<div class="page-header">
    <h2><i class="bi bi-box-seam me-2"></i>Products</h2>
    <a href="{{ route('admin.items.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Product
    </a>
</div>

<div class="product-table-wrapper">
    <div style="overflow-x: auto;">
        <table class="table align-middle mb-0">
            <thead>
                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Image</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">SKU</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Name</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Category</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Price</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Stock</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Condition</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Status</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr style="border-bottom: 1px solid #f1f3f5; transition: all 0.2s ease;">
                    <td style="padding: 1rem;">
                        <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://via.placeholder.com/50' }}" 
                             class="product-image rounded" alt="{{ $item->name }}">
                    </td>
                    <td style="padding: 1rem;">
                        <code style="background-color: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 0.4rem;">{{ $item->sku }}</code>
                    </td>
                    <td style="padding: 1rem;">
                        <div style="font-weight: 600; color: #212529;">{{ Str::limit($item->name, 40) }}</div>
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge" style="background-color: rgba(59, 130, 246, 0.15); color: #1e3a8a; padding: 0.5rem 0.875rem; border-radius: 50px;">
                            {{ $item->category->name ?? '-' }}
                        </span>
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.125rem;">
                            <div style="font-size: 0.75rem; color: #0066cc; font-weight: 600;">Rp</div>
                            <div style="font-size: 1rem; color: #0066cc; font-weight: 700;">{{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </td>
                    <td style="padding: 1rem;">
                        @if($item->stock <= $item->stock_min && $item->stock > 0)
                            <span class="badge stock-badge-low" style="background-color: rgba(245, 158, 11, 0.15); color: #78350f; padding: 0.5rem 0.875rem; border-radius: 50px;">
                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $item->stock }}
                            </span>
                        @elseif($item->stock == 0)
                            <span class="badge" style="background-color: rgba(239, 68, 68, 0.15); color: #7f1d1d; padding: 0.5rem 0.875rem; border-radius: 50px;">
                                Out of Stock
                            </span>
                        @else
                            <span class="badge" style="background-color: rgba(16, 185, 129, 0.15); color: #065f46; padding: 0.5rem 0.875rem; border-radius: 50px;">
                                {{ $item->stock }}
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        <span class="badge" style="background-color: rgba(59, 130, 246, 0.15); color: #1e3a8a; padding: 0.5rem 0.875rem; border-radius: 50px; text-transform: capitalize;">
                            {{ $item->condition }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        @if($item->is_active)
                            <span class="badge" style="background-color: rgba(16, 185, 129, 0.15); color: #065f46; padding: 0.5rem 0.875rem; border-radius: 50px;">
                                <i class="bi bi-check-circle me-1"></i>Active
                            </span>
                        @else
                            <span class="badge" style="background-color: rgba(107, 114, 128, 0.15); color: #374151; padding: 0.5rem 0.875rem; border-radius: 50px;">
                                <i class="bi bi-x-circle me-1"></i>Inactive
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <div class="action-buttons">
                            <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger" title="Delete"
                                    onclick="if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-{{ $item->id }}').submit();">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                        <form id="delete-{{ $item->id }}" action="{{ route('admin.items.destroy', $item) }}" method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 3rem 1rem;">
                        <div style="animation: slideInUp 0.6s ease-out;">
                            <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                            <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 0.5rem;">No products found</p>
                            <p style="color: #adb5bd; font-size: 0.95rem;">Add your first product to get started!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($items->count() > 0)
        <div style="padding: 1.5rem; border-top: 1px solid #e9ecef; background-color: #f8f9fa; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <div style="display: flex; gap: 0.5rem;">
                <!-- Previous Button -->
                @if($items->onFirstPage())
                    <button class="btn btn-sm btn-outline-secondary" disabled>
                        <i class="bi bi-chevron-left me-1"></i>Previous
                    </button>
                @else
                    <a href="{{ $items->previousPageUrl() }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-chevron-left me-1"></i>Previous
                    </a>
                @endif

                <!-- Next Button -->
                @if($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}" class="btn btn-sm btn-outline-primary">
                        Next<i class="bi bi-chevron-right ms-1"></i>
                    </a>
                @else
                    <button class="btn btn-sm btn-outline-secondary" disabled>
                        Next<i class="bi bi-chevron-right ms-1"></i>
                    </button>
                @endif
            </div>

            <!-- Page Info -->
            <div style="color: #6c757d; font-size: 0.95rem; font-weight: 500;">
                Page <strong>{{ $items->currentPage() }}</strong> of <strong>{{ $items->lastPage() }}</strong>
                <span style="margin-left: 1rem; opacity: 0.7;">{{ $items->total() }} total items</span>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            if (index < 9) {
                row.style.animation = `fadeIn 0.6s ease-out ${index * 0.05}s backwards`;
            }
        });
    });
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    tbody tr:hover {
        background-color: #f8f9ff;
        box-shadow: inset 0 0 0 1px rgba(9, 63, 180, 0.1);
    }
</style>
@endsection