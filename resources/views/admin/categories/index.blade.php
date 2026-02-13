@extends('layouts.admin')

@section('title', 'Manage Categories')

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

    .categories-table-wrapper {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
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

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header .btn {
            width: 100%;
        }
    }
</style>

<div class="page-header">
    <h2><i class="bi bi-tags me-2"></i>Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Category
    </a>
</div>

<div class="categories-table-wrapper">
    <div style="overflow-x: auto;">
        <table class="table align-middle mb-0">
            <thead>
                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; width: 60px;">#</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Name</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Slug</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Products</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem;">Created</th>
                    <th style="padding: 1rem; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr style="border-bottom: 1px solid #f1f3f5; transition: all 0.2s ease;">
                    <td style="padding: 1rem; color: #6c757d; font-weight: 500;">{{ $category->id }}</td>
                    <td style="padding: 1rem;">
                        <div style="font-weight: 600; color: #212529;">{{ $category->name }}</div>
                    </td>
                    <td style="padding: 1rem;">
                        <code style="background-color: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 0.4rem;">{{ $category->slug }}</code>
                    </td>
                    <td style="padding: 1rem;">
                        @if($category->items_count > 0)
                            <span class="badge" style="background-color: rgba(9, 63, 180, 0.15); color: #072A80; padding: 0.5rem 0.875rem; border-radius: 50px;">
                                {{ $category->items_count }} <i class="bi bi-box-seam ms-1"></i>
                            </span>
                        @else
                            <span class="badge" style="background-color: rgba(107, 114, 128, 0.15); color: #374151; padding: 0.5rem 0.875rem; border-radius: 50px;">
                                No items
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem; color: #6c757d;">
                        {{ $category->created_at->format('d M Y') }}
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="btn btn-outline-primary" style="width: 36px; height: 36px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 0.5rem; transition: all 0.2s ease;" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger" 
                                    style="width: 36px; height: 36px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 0.5rem; transition: all 0.2s ease;" 
                                    title="Delete"
                                    onclick="if(confirm('Are you sure? This will delete the category.')) document.getElementById('delete-{{ $category->id }}').submit();">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                        <form id="delete-{{ $category->id }}" 
                              action="{{ route('admin.categories.destroy', $category) }}" 
                              method="POST" class="d-none">
                            @csrf 
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem 1rem;">
                        <div style="animation: slideInUp 0.6s ease-out;">
                            <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                            <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 0.5rem;">No categories found</p>
                            <p style="color: #adb5bd; font-size: 0.95rem;">Create your first category to get started!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->count() > 0)
        <div style="padding: 1.5rem; border-top: 1px solid #e9ecef; background-color: #f8f9fa;">
            {{ $categories->links() }}
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
    
    .btn-outline-primary:hover,
    .btn-outline-danger:hover {
        transform: translateY(-2px);
    }
</style>
@endsection