<script src="{{ asset('template/plugins/cleave-js/cleave.min.js') }}"></script>
<script src="{{ asset('template/plugins/cleave-js/addons/cleave-phone.id.js') }}"></script>

<script>
    function initPriceFormat()
    {
        $('.input-price-format').toArray().forEach(function(field){
            new Cleave(field, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            })
        })
    }

    function initPhoneNumber()
    {
        $('.input-phone-number').toArray().forEach(function(field){
            new Cleave(field, {
                phone: true,
                phoneRegionCode: 'ID'
            })
        })
    }
</script>
