@php
    $structured = $page->getStructuredContent();
@endphp

@if($structured && !empty($structured['rows']))
    <div class="page-rows prose dark:prose-invert max-w-none space-y-8">
        @foreach($structured['rows'] as $row)
            <div class="page-row grid gap-6 @if($row['type'] === '1-col') grid-cols-1 @elseif($row['type'] === '2-col') grid-cols-1 md:grid-cols-2 @else grid-cols-1 md:grid-cols-3 @endif">
                @foreach($row['columns'] ?? [] as $col)
                    <div class="page-column">
                        @if(($col['type'] ?? 'text') === 'image' && !empty($col['url']))
                            <div class="page-column-image">
                                <img src="{{ $col['url'] }}" alt="" class="w-full h-auto rounded-lg object-cover">
                            </div>
                        @else
                            <div class="page-column-text trix-content">
                                {!! $col['content'] ?? '' !!}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@else
    <div class="prose dark:prose-invert max-w-none trix-content">
        {!! $page->content !!}
    </div>
@endif
