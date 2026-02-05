@props(['initialRows' => [], 'uploadUrl' => '', 'csrf' => ''])

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix@2.1.0/dist/trix.css">
    <style>
        /* Minimal Trix: hide file attach, compact toolbar */
        trix-toolbar .trix-button--icon-attach,
        trix-toolbar[data-trix-button-group="file-tools"],
        trix-toolbar .trix-button-group:first-child .trix-button--icon-attach { display: none !important; }
        trix-toolbar .trix-button-row {
            flex-wrap: wrap;
            gap: 0.25rem;
            justify-content: flex-start !important;
        }
        trix-toolbar .trix-button-group-spacer { display: none !important; }
        trix-toolbar .trix-button-group {
            border: none !important;
            margin-left: 0 !important;
        }
        trix-toolbar .trix-button-group:not(:first-child) {
            border-left: 1px solid rgb(209 213 219) !important;
            margin-left: 0.25rem !important;
        }
        
        trix-toolbar .trix-button { font-size: 0.75em !important; padding: 0 0.35em !important; }
        trix-toolbar .trix-button--icon { width: 2em !important; height: 2em !important; max-width: 2em !important; }
        trix-editor { min-height: 100px; font-size: 0.875rem; }
        /* Restore list styling (Tailwind preflight removes it) */
        trix-editor ul { list-style-type: disc !important; margin-left: 1em !important; padding-left: 1.5em !important; }
        trix-editor ol { list-style-type: decimal !important; margin-left: 1em !important; padding-left: 1.5em !important; }
        trix-editor li { margin-left: 0; }
        trix-editor, trix-toolbar { border-color: rgb(209 213 219); }
        .trix-wrapper { overflow: visible; }
        trix-toolbar .trix-button--icon-code { display: none !important; }
        trix-toolbar .trix-button--icon-quote { display: none !important; }
        trix-toolbar .trix-button--icon-decrease-nesting-level { display: none !important; }
        trix-toolbar .trix-button--icon-increase-nesting-level { display: none !important; }
        trix-toolbar .trix-button--icon-code-block { display: none !important; }
        trix-toolbar .trix-button--icon-code-block-low { display: none !important; }
        trix-toolbar .trix-button--icon-code-block-medium { display: none !important; }
        trix-toolbar .trix-button--icon-code-block-high { display: none !important; }
        trix-toolbar .trix-button--icon-code-block-very-high { display: none !important; }
        trix-toolbar .trix-button--icon-code-block-very-low { display: none !important; }

        .dark trix-editor, .dark trix-toolbar { border: none !important; background: rgb(55 65 81); color: rgb(243 244 246); }
        .dark trix-toolbar .trix-button-group, .dark trix-toolbar .trix-button-group:not(:first-child) { border: none !important; }
        .dark trix-toolbar .trix-button { border: none !important; color: rgb(243 244 246); }
        .dark trix-toolbar .trix-button--icon::before { filter: invert(1); opacity: 0.9; }
        .dark trix-toolbar .trix-button--icon.trix-active::before { opacity: 1; }
        .dark trix-toolbar .trix-button--icon:disabled::before { opacity: 0.3; }
    </style>
@endpush
@push('scripts')
    <script src="https://unpkg.com/trix@2.1.0/dist/trix.umd.min.js"></script>
    <script>
        document.addEventListener('trix-file-accept', function(e) { e.preventDefault(); });
        // Fix Trix link dialog: type="url" causes strict validation to fail, making links insert as plain text
        (function() {
            function fixTrixLinkInputs() {
                document.querySelectorAll('.trix-input--dialog[name="href"], input[name="href"][data-trix-input]').forEach(function(el) {
                    if (el.type === 'url') el.type = 'text';
                });
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', fixTrixLinkInputs);
            } else {
                fixTrixLinkInputs();
            }
            var observer = new MutationObserver(function() {
                fixTrixLinkInputs();
            });
            observer.observe(document.body, { childList: true, subtree: true });
        })();
    </script>
@endpush

<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
    <p class="text-sm text-gray-500 mb-4">Build your page with rows. Add rows, choose column layout, and add text or images to each column.</p>

    <div class="space-y-4" x-data="pageRowEditor(
        @js($initialRows),
        @js($uploadUrl),
        @js($csrf)
    )">
        <input type="hidden" name="content" x-ref="contentInput" value="">

        <div class="space-y-4" x-sort="onSort($item, $position)">
            <template x-for="(row, rowIndex) in rows" :key="row.id">
                <div x-sort:item="row.id" class="page-row-item border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-900/50 flex flex-col" :data-row-id="row.id">
                    {{-- Row header: drag handle, label, up/down/delete --}}
                    <div class="flex items-center justify-between w-full px-4 py-2 bg-gray-100 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-600 shrink-0">
                        <div class="flex items-center gap-2">
                            <div class="sort-handle cursor-grab active:cursor-grabbing p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded" x-sort:handle title="Drag to reorder">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 6h2v2H8V6zm0 5h2v2H8v-2zm0 5h2v2H8v-2zm5-10h2v2h-2V6zm0 5h2v2h-2v-2zm0 5h2v2h-2v-2z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest" x-text="'Row ' + (rowIndex + 1)"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" x-sort:ignore @click="moveRow(rowIndex, -1)" :disabled="rowIndex === 0"
                                class="p-1.5 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                            </button>
                            <button type="button" x-sort:ignore @click="moveRow(rowIndex, 1)" :disabled="rowIndex === rows.length - 1"
                                class="p-1.5 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 disabled:opacity-40 disabled:cursor-not-allowed rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <button type="button" x-sort:ignore @click="removeRow(rowIndex)"
                                class="p-1.5 text-red-500 hover:text-red-700 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>
                    {{-- Content area: columns grid --}}
                    <div class="grid gap-4 p-4 w-full" :class="{
                    'grid-cols-1': row.type === '1-col',
                    'grid-cols-2': row.type === '2-col',
                    'grid-cols-3': row.type === '3-col'
                }">
                    <template x-for="(col, colIndex) in row.columns" :key="col.id">
                        <div class="space-y-2">
                            <div class="flex gap-2">
                                <button type="button" @click="setColumnType(rowIndex, colIndex, 'text')"
                                    :class="col.type === 'text' ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400'"
                                    class="px-2 py-1 text-xs font-medium rounded">Text</button>
                                <button type="button" @click="setColumnType(rowIndex, colIndex, 'image')"
                                    :class="col.type === 'image' ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400'"
                                    class="px-2 py-1 text-xs font-medium rounded">Image</button>
                            </div>
                            <div x-show="col.type === 'text'" x-cloak class="trix-wrapper rounded-md overflow-hidden border border-gray-300 dark:border-gray-600">
                                <input type="hidden" :id="'trix-' + row.id + '-' + col.id" :value="col.content">
                                <trix-editor
                                    :input="'trix-' + row.id + '-' + col.id"
                                    placeholder="Enter text content..."
                                    class="trix-content"
                                    @trix-initialize="if (col.content && $event.target.editor) $event.target.editor.loadHTML(col.content)"
                                    @trix-change="col.content = document.getElementById($event.target.getAttribute('input'))?.value || ''"
                                ></trix-editor>
                            </div>
                            <div x-show="col.type === 'image'" x-cloak class="min-h-[120px]"
                                x-data="menuImageUploader({
                                        uploadUrl: uploadUrl,
                                        csrf: csrf,
                                        aspectRatio: 0,
                                        outputMaxWidth: 1200,
                                        outputMaxHeight: 900,
                                        outputType: 'image/jpeg',
                                        initialPath: col.path || '',
                                        initialUrl: col.url || '',
                                        rowIndex: rowIndex,
                                        colIndex: colIndex,
                                    })"
                                    @image-uploaded="setColumnImage($event.detail.rowIndex ?? rowIndex, $event.detail.colIndex ?? colIndex, $event.detail.path, $event.detail.url)"
                                    @image-removed="if ($event.detail?.rowIndex != null) setColumnImage($event.detail.rowIndex, $event.detail.colIndex, null, null)">
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 flex flex-col items-center justify-center min-h-[120px] bg-white dark:bg-gray-800">
                                        <template x-if="!imageUrl">
                                            <div class="text-center">
                                                <input type="file" x-ref="fileInput" accept="image/*" @change="onPickFile($event)" class="hidden" :id="'page-img-' + row.id + '-' + col.id">
                                                <label :for="'page-img-' + row.id + '-' + col.id" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                                    Upload & Crop
                                                </label>
                                            </div>
                                        </template>
                                        <template x-if="imageUrl">
                                            <div class="relative w-full group">
                                                <img :src="imageUrl" class="max-h-96 w-auto mx-auto rounded object-contain" alt="Column image">
                                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 rounded">
                                                    <label :for="'page-img-' + row.id + '-' + col.id" class="cursor-pointer px-3 py-1.5 bg-white text-gray-800 text-xs font-medium rounded">Change</label>
                                                    <button type="button" @click="removeImage()" class="px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded">Remove</button>
                                                </div>
                                                <input type="file" x-ref="fileInput" accept="image/*" @change="onPickFile($event)" class="hidden" :id="'page-img-' + row.id + '-' + col.id">
                                            </div>
                                        </template>
                                    </div>
                                    <div x-show="open" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                                        <div class="absolute inset-0 bg-gray-900/90" @click="closeModal()"></div>
                                        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full overflow-hidden">
                                            <div class="p-4 border-b flex justify-between items-center">
                                                <span class="font-semibold">Crop Image</span>
                                                <button type="button" @click="closeModal()" class="text-gray-500 hover:text-gray-700">✕</button>
                                            </div>
                                            <div class="p-4 max-h-[60vh] overflow-hidden">
                                                <img x-ref="cropImage" alt="Crop" class="max-w-full">
                                            </div>
                                            <div class="p-4 border-t flex justify-end gap-2">
                                                <button type="button" @click="closeModal()" class="px-4 py-2 text-gray-600">Cancel</button>
                                                <button type="button" @click="cropAndUpload()" :disabled="uploading" class="px-4 py-2 bg-indigo-600 text-white rounded disabled:opacity-50">Save & Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </template>
                </div>
                </div>
        </template>
        </div>

        <div class="flex flex-wrap gap-2">
            <span class="text-sm text-gray-500 self-center">Add row:</span>
            <button type="button" @click="addRow('1-col')" class="px-3 py-1.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg">1 Column</button>
            <button type="button" @click="addRow('2-col')" class="px-3 py-1.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg">2 Columns</button>
            <button type="button" @click="addRow('3-col')" class="px-3 py-1.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg">3 Columns</button>
        </div>
    </div>
</div>
