<x-admin-layout>
    <x-admin-website-header :website="$website" title="Website Images" />

    <div class="py-6 space-y-6" x-data="{ 
        activeTab: localStorage.getItem('last_logo_tab_{{ $website->id }}') || @js($website->settings['preferred_logo_type'] ?? 'rect'),
        preferredType: @js($website->settings['preferred_logo_type'] ?? 'rect'),
        confirmModal: {
            show: false,
            type: '',
            title: '',
            message: '',
            loading: false
        },
        async setPreferred(type) {
            try {
                const res = await fetch(@js(route('admin.websites.images.set-preferred-logo', $website)), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': @js(csrf_token()),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ type })
                });
                if (res.ok) {
                    this.preferredType = type;
                }
            } catch (err) {
                alert('Failed to set preferred logo');
            }
        },
        openDeleteModal(type) {
            this.confirmModal.type = type;
            this.confirmModal.title = type === 'rect' ? 'Remove Rectangular Logo' : 'Remove Square Logo';
            this.confirmModal.message = 'Are you sure you want to remove this logo? This will clear the logo from your website immediately.';
            this.confirmModal.show = true;
        },
        async confirmDelete() {
            if (this.confirmModal.loading) return;
            this.confirmModal.loading = true;
            try {
                const res = await fetch(@js(route('admin.websites.images.remove-logo', $website)) + `?type=${this.confirmModal.type}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': @js(csrf_token()),
                        'Accept': 'application/json',
                    },
                });
                if (res.ok) {
                    // We need to trigger the removeImage on the correct uploader component
                    // Since they are separate components, we'll use an event
                    window.dispatchEvent(new CustomEvent('logo-removed', { detail: { type: this.confirmModal.type } }));
                    this.confirmModal.show = false;
                }
            } catch (err) {
                alert('Failed to remove logo');
            } finally {
                this.confirmModal.loading = false;
            }
        }
    }"
    x-init="$watch('activeTab', val => localStorage.setItem('last_logo_tab_{{ $website->id }}', val))">
        
        <!-- Tab Switcher -->
        <div class="flex justify-center">
            <div class="inline-flex p-1 bg-gray-100 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-700">
                <button 
                    @click="activeTab = 'rect'"
                    :class="activeTab === 'rect' ? 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="px-6 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all"
                >
                    Rectangular Logo (3:1)
                </button>
                <button 
                    @click="activeTab = 'square'"
                    :class="activeTab === 'square' ? 'bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="px-6 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all"
                >
                    Square Logo (1:1)
                </button>
            </div>
        </div>

        <!-- Rectangular Logo Management Card -->
        <div x-show="activeTab === 'rect'" x-cloak class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between">
                <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ __('Rectangular Website Logo') }}</h3>
                <div class="flex items-center gap-3">
                    <template x-if="preferredType === 'rect'">
                        <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-[10px] font-black uppercase rounded-full border border-green-200 dark:border-green-800 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Active
                        </span>
                    </template>
                    <button 
                        x-show="preferredType !== 'rect'"
                        @click="setPreferred('rect')"
                        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-[10px] font-black uppercase rounded-full transition-all"
                    >
                        Set as Active
                    </button>
                </div>
            </div>
            <div class="p-8">
                <div 
                    x-data="menuImageUploader({
                        uploadUrl: @js(route('admin.websites.images.upload-logo', ['website' => $website, 'type' => 'rect'])),
                        csrf: @js(csrf_token()),
                        aspectRatio: 3 / 1,
                        outputWidth: 1200,
                        outputHeight: 400,
                        outputType: 'image/png',
                        initialPath: @js($website->logo_rect ?? ''),
                        initialUrl: @js($website->logo_rect_url ?? ''),
                    })"
                    @logo-removed.window="if($event.detail.type === 'rect') removeImage()"
                    class="space-y-6"
                >
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <!-- Preview Area -->
                        <div class="w-full md:w-96 shrink-0">
                            <div class="aspect-[3/1] bg-gray-50 dark:bg-gray-900/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden relative group">
                                <template x-if="imageUrl">
                                    <img :src="imageUrl" class="w-full h-full object-contain p-4" alt="Website Rectangular Logo">
                                </template>
                                <template x-if="!imageUrl">
                                    <div class="text-center p-6">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">No Logo Uploaded</p>
                                    </div>
                                </template>
                                
                                <div x-show="imageUrl" class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" @click="openDeleteModal('rect')" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Area -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Upload Rectangular Logo</h4>
                                <p class="text-sm text-gray-500">Recommended: 3:1 ratio PNG with transparent background. Minimum 1200x400px.</p>
                            </div>

                            <div class="relative">
                                <input 
                                    type="file" 
                                    x-ref="fileInput"
                                    accept="image/*"
                                    @change="onPickFile($event)"
                                    class="hidden"
                                    id="logo-upload-rect"
                                >
                                <label for="logo-upload-rect" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-xs uppercase tracking-widest cursor-pointer transition-all shadow-lg shadow-indigo-500/20">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                    Select Image
                                </label>
                            </div>

                            <div x-show="imagePath" class="pt-4 border-t border-gray-50 dark:border-gray-700">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Current S3 Path</p>
                                <p class="text-xs font-mono text-gray-500 break-all" x-text="imagePath"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Crop Modal -->
                    <div x-show="open" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
                        <div class="absolute inset-0 bg-gray-900/90 backdrop-blur-sm" @click="closeModal()"></div>
                        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden border border-gray-100 dark:border-gray-700">
                            <div class="px-8 py-6 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between bg-gray-50 dark:bg-gray-900/50">
                                <div>
                                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">Crop Rectangular Logo</h3>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Adjust to fit the 3:1 frame</p>
                                </div>
                                <button type="button" @click="closeModal()" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            <div class="p-8">
                                <div class="max-h-[60vh] overflow-hidden rounded-2xl bg-gray-100 dark:bg-black/20 border border-gray-200 dark:border-gray-700">
                                    <img x-ref="cropImage" alt="Crop target" class="max-w-full">
                                </div>
                            </div>
                            <div class="px-8 py-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-50 dark:border-gray-700 flex justify-end gap-4">
                                <button type="button" @click="closeModal()" class="px-6 py-3 text-xs font-black uppercase tracking-widest text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors" :disabled="uploading">
                                    Cancel
                                </button>
                                <button type="button" @click="cropAndUpload()" class="inline-flex items-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20 disabled:opacity-50" :disabled="uploading">
                                    <template x-if="!uploading">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            Save & Upload
                                        </span>
                                    </template>
                                    <template x-if="uploading">
                                        <span class="flex items-center">
                                            <svg class="animate-spin h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            Uploading...
                                        </span>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Square Logo Management Card -->
        <div x-show="activeTab === 'square'" x-cloak class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-8 py-5 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between">
                <h3 class="font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ __('Square Website Logo') }}</h3>
                <div class="flex items-center gap-3">
                    <template x-if="preferredType === 'square'">
                        <span class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-[10px] font-black uppercase rounded-full border border-green-200 dark:border-green-800 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Active
                        </span>
                    </template>
                    <button 
                        x-show="preferredType !== 'square'"
                        @click="setPreferred('square')"
                        class="px-3 py-1 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-[10px] font-black uppercase rounded-full transition-all"
                    >
                        Set as Active
                    </button>
                </div>
            </div>
            <div class="p-8">
                <div 
                    x-data="menuImageUploader({
                        uploadUrl: @js(route('admin.websites.images.upload-logo', ['website' => $website, 'type' => 'square'])),
                        csrf: @js(csrf_token()),
                        aspectRatio: 1 / 1,
                        outputWidth: 512,
                        outputHeight: 512,
                        outputType: 'image/png',
                        initialPath: @js($website->logo ?? ''),
                        initialUrl: @js($website->logo_url ?? ''),
                    })"
                    @logo-removed.window="if($event.detail.type === 'square') removeImage()"
                    class="space-y-6"
                >
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <!-- Preview Area -->
                        <div class="w-full md:w-64 shrink-0">
                            <div class="aspect-square bg-gray-50 dark:bg-gray-900/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden relative group">
                                <template x-if="imageUrl">
                                    <img :src="imageUrl" class="w-full h-full object-contain p-4" alt="Website Logo">
                                </template>
                                <template x-if="!imageUrl">
                                    <div class="text-center p-6">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">No Logo Uploaded</p>
                                    </div>
                                </template>
                                
                                <div x-show="imageUrl" class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button type="button" @click="openDeleteModal('square')" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Area -->
                        <div class="flex-1 space-y-4">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Upload Square Logo</h4>
                                <p class="text-sm text-gray-500">Recommended: Square PNG with transparent background. Minimum 512x512px.</p>
                            </div>

                            <div class="relative">
                                <input 
                                    type="file" 
                                    x-ref="fileInput"
                                    accept="image/*"
                                    @change="onPickFile($event)"
                                    class="hidden"
                                    id="logo-upload-square"
                                >
                                <label for="logo-upload-square" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-xs uppercase tracking-widest cursor-pointer transition-all shadow-lg shadow-indigo-500/20">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                    Select Image
                                </label>
                            </div>

                            <div x-show="imagePath" class="pt-4 border-t border-gray-50 dark:border-gray-700">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Current S3 Path</p>
                                <p class="text-xs font-mono text-gray-500 break-all" x-text="imagePath"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Crop Modal -->
                    <div x-show="open" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
                        <div class="absolute inset-0 bg-gray-900/90 backdrop-blur-sm" @click="closeModal()"></div>
                        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden border border-gray-100 dark:border-gray-700">
                            <div class="px-8 py-6 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between bg-gray-50 dark:bg-gray-900/50">
                                <div>
                                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter">Crop Square Logo</h3>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Adjust to fit the square frame</p>
                                </div>
                                <button type="button" @click="closeModal()" class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            <div class="p-8">
                                <div class="max-h-[60vh] overflow-hidden rounded-2xl bg-gray-100 dark:bg-black/20 border border-gray-200 dark:border-gray-700">
                                    <img x-ref="cropImage" alt="Crop target" class="max-w-full">
                                </div>
                            </div>
                            <div class="px-8 py-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-50 dark:border-gray-700 flex justify-end gap-4">
                                <button type="button" @click="closeModal()" class="px-6 py-3 text-xs font-black uppercase tracking-widest text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors" :disabled="uploading">
                                    Cancel
                                </button>
                                <button type="button" @click="cropAndUpload()" class="inline-flex items-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20 disabled:opacity-50" :disabled="uploading">
                                    <template x-if="!uploading">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            Save & Upload
                                        </span>
                                    </template>
                                    <template x-if="uploading">
                                        <span class="flex items-center">
                                            <svg class="animate-spin h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            Uploading...
                                        </span>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div x-show="confirmModal.show" x-cloak class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-6">
            <div class="absolute inset-0 bg-gray-900/90 backdrop-blur-sm" @click="confirmModal.show = false"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8 text-center">
                    <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6 text-red-600 dark:text-red-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter mb-2" x-text="confirmModal.title"></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed" x-text="confirmModal.message"></p>
                </div>
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-50 dark:border-gray-700 flex flex-col sm:flex-row gap-3">
                    <button type="button" @click="confirmModal.show = false" class="flex-1 px-6 py-3 text-xs font-black uppercase tracking-widest text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors" :disabled="confirmModal.loading">
                        Cancel
                    </button>
                    <button type="button" @click="confirmDelete()" class="flex-1 inline-flex items-center justify-center px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-red-500/20 disabled:opacity-50" :disabled="confirmModal.loading">
                        <template x-if="!confirmModal.loading">
                            <span>Remove Logo</span>
                        </template>
                        <template x-if="confirmModal.loading">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.css">
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/cropperjs@1.6.2/dist/cropper.min.js"></script>
    @endpush
</x-admin-layout>
