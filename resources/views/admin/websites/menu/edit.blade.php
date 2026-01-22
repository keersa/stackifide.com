<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <span>{{ __('Edit Menu Item') }} - {{ $website->name }}</span>
        </div>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('admin.websites.menu.update', [$website, $menuItem]) }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Menu Item Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name *</label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   value="{{ old('name', $menuItem->name) }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                            <input type="text" 
                                   name="category" 
                                   id="category"
                                   value="{{ old('category', $menuItem->category) }}"
                                   placeholder="e.g., Appetizers, Entrees, Desserts"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" 
                                      id="description"
                                      rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $menuItem->description) }}</textarea>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price *</label>
                            <input type="number" 
                                   name="price" 
                                   id="price"
                                   value="{{ old('price', $menuItem->price) }}"
                                   step="0.01"
                                   min="0"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                            <input type="number" 
                                   name="sort_order" 
                                   id="sort_order"
                                   value="{{ old('sort_order', $menuItem->sort_order) }}"
                                   min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            @php
                                $initialPath = old('image', $menuItem->image ?? '');
                                $initialUrl = '';
                                if (is_string($initialPath) && (str_starts_with($initialPath, 'http://') || str_starts_with($initialPath, 'https://'))) {
                                    $initialUrl = $initialPath;
                                } elseif (!empty($initialPath)) {
                                    try {
                                        $initialUrl = \Illuminate\Support\Facades\Storage::disk('s3')->url($initialPath);
                                    } catch (\Throwable $e) {
                                        $initialUrl = asset('storage/' . $initialPath);
                                    }
                                }
                            @endphp

                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
                            <div
                                x-data="menuImageUploader({
                                    uploadUrl: @js(route('admin.websites.menu.upload-image', $website)),
                                    csrf: @js(csrf_token()),
                                    aspectRatio: 4 / 3,
                                    outputWidth: 1200,
                                    outputHeight: 900,
                                    outputType: 'image/jpeg',
                                    outputQuality: 0.88,
                                    initialPath: @js($initialPath),
                                    initialUrl: @js($initialUrl),
                                })"
                                class="mt-1"
                            >
                                <input type="hidden" name="image" x-ref="imageInput" x-model="imagePath">

                                <div class="flex items-start gap-4">
                                    <div class="flex-1">
                                        <input
                                            type="file"
                                            x-ref="fileInput"
                                            accept="image/*"
                                            @change="onPickFile($event)"
                                            class="block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700"
                                        >
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Crop will be locked to 4:3 and uploaded to S3.</p>
                                        <template x-if="imagePath">
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 break-all">
                                                Saved key: <span class="font-mono" x-text="imagePath"></span>
                                            </p>
                                        </template>
                                    </div>

                                    <div class="w-32">
                                        <template x-if="imageUrl">
                                            <div class="relative">
                                                <img :src="imageUrl" class="w-32 h-24 object-cover rounded border border-gray-200 dark:border-gray-700" alt="Menu item image preview">
                                                <button type="button"
                                                    @click="removeImage()"
                                                    class="mt-2 w-full text-xs bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 py-1 rounded">
                                                    Remove
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Crop modal -->
                                <div
                                    x-show="open"
                                    x-cloak
                                    class="fixed inset-0 z-50 flex items-center justify-center"
                                >
                                    <div class="absolute inset-0 bg-black/60" @click="closeModal()"></div>
                                    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-[min(900px,95vw)] p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">Crop image</h4>
                                            <button type="button" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" @click="closeModal()">✕</button>
                                        </div>
                                        <div class="max-h-[70vh] overflow-hidden rounded border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                                            <img x-ref="cropImage" alt="Crop target" class="max-w-full">
                                        </div>
                                        <div class="mt-4 flex justify-end gap-2">
                                            <button type="button"
                                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded"
                                                @click="closeModal()"
                                                :disabled="uploading"
                                            >
                                                Cancel
                                            </button>
                                            <button type="button"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded"
                                                @click="cropAndUpload()"
                                                :disabled="uploading"
                                            >
                                                <span x-show="!uploading">Crop & Upload</span>
                                                <span x-show="uploading" style="display:none;">Uploading…</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_available" 
                                   id="is_available"
                                   value="1"
                                   {{ old('is_available', $menuItem->is_available) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                            <label for="is_available" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Available
                            </label>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dietary Information</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                @php
                                    $dietaryInfo = is_array($menuItem->dietary_info) ? $menuItem->dietary_info : [];
                                    $oldDietary = old('dietary_info', $dietaryInfo);
                                @endphp
                                @foreach(['vegetarian', 'vegan', 'gluten-free', 'dairy-free', 'nut-free', 'spicy', 'halal', 'kosher'] as $dietary)
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="dietary_info[]" 
                                               value="{{ $dietary }}"
                                               {{ in_array($dietary, $oldDietary) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('-', ' ', $dietary)) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.websites.menu.index', $website) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Update Menu Item
                </button>
            </div>
        </form>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css">
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js"></script>
    @endpush
</x-admin-layout>
