<div class="flex space-x-4">
    Check ehre
    @foreach ($socialLinks as $platform => $link)
        @if ($link)
            <a href="{{ $link }}" target="_blank" class="text-gray-600 hover:text-blue-500">
                @if($platform == "Facebook Link")
                <x-filament::icon-button
                    icon="heroicon-m-plus"
                    label="New label"
                />    
                @elseif($platform == "Twitter Link")
                <x-filament::icon-button
                    icon="heroicon-m-minus"
                    label="New label"
                />
                @endif
            </a>
        @endif
    @endforeach
</div>
