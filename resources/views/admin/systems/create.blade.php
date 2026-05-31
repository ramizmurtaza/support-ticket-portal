@extends('admin.layouts.admin')

@section('title', 'Add System')
@section('page-title', 'Add New System')

@section('content')

<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.systems.store') }}">
            @csrf

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">System Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror"
                       placeholder="e.g. Evexia HIS">
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="system_id" class="block text-sm font-medium text-gray-700 mb-1">
                    System ID <span class="text-gray-400 font-normal">(slug format, e.g. evexia-his)</span>
                </label>
                <input type="text" id="system_id" name="system_id" value="{{ old('system_id') }}" required
                       class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono @error('system_id') border-red-400 @enderror"
                       placeholder="evexia-his"
                       pattern="[a-z0-9_-]+"
                       title="Lowercase letters, numbers, hyphens and underscores only">
                @error('system_id')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-400 mt-1">Lowercase letters, numbers, hyphens and underscores only. Cannot be changed later.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Create System
                </button>
                <a href="{{ route('admin.systems.index') }}"
                   class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
