@extends('admin.layouts.admin')

@section('title', 'Edit System')
@section('page-title', 'Edit System: ' . $system->name)

@section('content')

<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.systems.update', $system->id) }}">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">System Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $system->name) }}" required
                       class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">System ID</label>
                <input type="text" value="{{ $system->system_id }}" disabled
                       class="w-full rounded-lg border border-gray-200 text-sm px-3 py-2 bg-gray-50 text-gray-500 font-mono cursor-not-allowed">
                <p class="text-xs text-gray-400 mt-1">System ID cannot be changed after creation.</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $system->is_active) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-200 peer-checked:bg-blue-600 rounded-full transition-colors"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Save Changes
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
