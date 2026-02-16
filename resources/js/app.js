import './bootstrap';

import Alpine from 'alpinejs';
import Sort from '@alpinejs/sort';

Alpine.plugin(Sort);
window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('menuImageUploader', (options = {}) => ({
        aspectRatio: options.aspectRatio ?? (4 / 3),
        uploadUrl: options.uploadUrl ?? null,
        csrf: options.csrf ?? null,
        rowIndex: options.rowIndex ?? null,
        colIndex: options.colIndex ?? null,
        outputWidth: options.outputWidth ?? 1200,
        outputHeight: options.outputHeight ?? 900,
        outputType: options.outputType ?? 'image/jpeg',
        // PNG is lossless: use 1.0 for no compression. JPEG/WebP: 0.92+ for high quality.
        outputQuality: options.outputQuality ?? (options.outputType === 'image/png' ? 1 : 0.92),
        fillColor: options.fillColor ?? 'transparent',
        cropper: null,
        uploading: false,
        imageUrl: options.initialUrl ?? '',
        imagePath: options.initialPath ?? '',
        open: false,

        onPickFile(e) {
            const file = e?.target?.files?.[0];
            if (!file) return;

            if (!window.Cropper) {
                alert('Cropper library not loaded yet. Please refresh and try again.');
                return;
            }

            const url = URL.createObjectURL(file);
            this.open = true;

            this.$nextTick(() => {
                const img = this.$refs.cropImage;
                img.src = url;

                if (this.cropper) this.cropper.destroy();
                this.cropper = new window.Cropper(img, {
                    aspectRatio: this.aspectRatio,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                });
            });
        },

        async cropAndUpload() {
            if (!this.cropper || this.uploading) return;
            if (!this.uploadUrl) {
                alert('Upload URL not configured.');
                return;
            }

            this.uploading = true;
            try {
                const canvasOptions = {
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                    minWidth: 0,
                    minHeight: 0,
                };
                if (this.fillColor && this.fillColor !== 'transparent') {
                    canvasOptions.fillColor = this.fillColor;
                } else {
                    canvasOptions.fillColor = 'rgba(0, 0, 0, 0)';
                }
                if (this.outputMaxWidth || this.outputMaxHeight) {
                    if (this.outputMaxWidth) canvasOptions.maxWidth = this.outputMaxWidth;
                    if (this.outputMaxHeight) canvasOptions.maxHeight = this.outputMaxHeight;
                } else {
                    canvasOptions.width = this.outputWidth;
                    canvasOptions.height = this.outputHeight;
                }
                const canvas = this.cropper.getCroppedCanvas(canvasOptions);

                const blob = await new Promise((resolve) =>
                    canvas.toBlob(resolve, this.outputType, this.outputQuality)
                );
                if (!blob) throw new Error('Could not process image.');

                const ext = this.outputType === 'image/webp' ? 'webp' : 'jpg';
                const file = new File([blob], `menu.${ext}`, { type: this.outputType });
                const form = new FormData();
                form.append('image', file);

                const csrf =
                    this.csrf ??
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content');

                const res = await fetch(this.uploadUrl, {
                    method: 'POST',
                    headers: {
                        ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
                        Accept: 'application/json',
                    },
                    body: form,
                });

                const contentType = res.headers.get('content-type') || '';
                const data = contentType.includes('application/json')
                    ? await res.json().catch(() => null)
                    : null;

                if (!res.ok) {
                    // Try to surface HTML/text errors (e.g. 500 error page) too
                    const text = data ? null : await res.text().catch(() => null);
                    const details = data?.details ? `\n\n${data.details}` : '';
                    throw new Error(
                        (data?.message || `Upload failed (HTTP ${res.status})`) +
                            details +
                            (text ? `\n\n${text.slice(0, 500)}` : '')
                    );
                }

                this.imagePath = data.path;
                this.imageUrl = data?.url || '';
                if (this.$refs.imageInput) this.$refs.imageInput.value = this.imagePath;
                this.$dispatch('image-uploaded', {
                    path: data.path,
                    url: data?.url || '',
                    rowIndex: this.rowIndex,
                    colIndex: this.colIndex,
                });
                this.closeModal();
            } catch (err) {
                alert(err?.message || 'Upload failed');
            } finally {
                this.uploading = false;
            }
        },

        removeImage() {
            this.imagePath = '';
            this.imageUrl = '';
            if (this.$refs.imageInput) this.$refs.imageInput.value = '';
            if (this.$refs.fileInput) this.$refs.fileInput.value = '';
            this.$dispatch('image-removed', { rowIndex: this.rowIndex, colIndex: this.colIndex, path: null, url: null });
        },

        closeModal() {
            this.open = false;
            if (this.cropper) {
                this.cropper.destroy();
                this.cropper = null;
            }
        },
    }));

});

Alpine.start();

// Import faded background script
//import './faded-bg';
