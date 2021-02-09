<div {{ $attributes->merge(['class' => '']) }}>
    <i class="text-shadow-dark-bg @if($type === 1) fas fa-comments text-green-300 @elseif($type === 3) fas fa-quote-left text-pink-500 @else fas fa-link text-yellow-400 @endif"></i>
</div>
