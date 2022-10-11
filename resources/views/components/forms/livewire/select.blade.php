<div>
    @php
        preg_match('/wire:model\=([\w\.]+)/', $options, $matches);
    @endphp
    <script type="text/javascript">
        {{-- jQuery cannot run before DOM is loaded --}}
        if (typeof reloadSelect2Elements === 'undefined') {
            window.addEventListener('load', (event) => {
                $('#{{ $id }}').on('change', function () {
                    @this.set('{{ $matches[1] }}', $(this).val());
                });
            });
        } else {
            $('#{{ $id }}').on('change', function () {
                @this.set('{{ $matches[1] }}', $(this).val());
            });
        }
    </script>
</div>
