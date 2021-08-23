<div class="-mt-6">
    <header class="flex items-center justify-between px-4 pt-6 pb-20 bg-gray-100 lg:px-16">
        <div class="flex items-center animate__animated animate__pulse animate__infinite">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="text-blue-600 bi bi-dot" viewBox="0 0 16 16">
                <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
            </svg>
            <span>Updating live</span>
        </div>
        <div class="flex items-center mr-6 md:mr-20 lg:mr-20">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="text-red-500 bi bi-youtube" viewBox="0 0 16 16">
                <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />
            </svg>
            <span class="ml-2 text-2xl font-semibold tracking-tighter text-gray-700">YouTube</span>
        </div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z" />
            </svg>
        </div>
    </header>
    <div class="flex flex-col items-center justify-center -mt-12">
        <div class="flex flex-col items-center justify-center">
            <img src="https://yt3.ggpht.com/ytc/AAUvwnhQStkaJSFrZmeqrKRU5cgY4cnVTtPFg4iCRC3q=s900-c-k-c0x00ffffff-no-rj" class="w-20 h-20 rounded-full" />
            <h2 class="mt-2 text-xl font-semibold">Clovon</h2>
        </div>
        <div class="flex flex-col items-center mt-16">
            <div wire:poll="fetchData">
                <div class="animate__animated animate__pulse animate__infinite">
                    <span class="text-6xl font-semibold">{{ $recentSubscribers }}</span>
                </div>
            </div>
            <span class="mt-3 text-xl text-gray-700">Subscribers</span>
        </div>
    </div>

    <div class="w-full" style="height: 50%;">
        <div class="px-10" id="chart"></div>
    </div>
</div>

@push('js')
<script>
    var options = {
        chart: {
            type: 'line',
            height: '250px',
            animations: {
                enabled: false,
            }
        },
        series: [{
            name: 'Subscribers',
            data: @json($subscribers)
        }],
        xaxis: {
            categories: @json($days)
        }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();

    document.addEventListener('livewire:load', () => {
        @this.on('refreshChart', (chartData) => {
            chart.updateSeries([{
                data: chartData.seriesData
            }])
        })
    })
</script>
@endpush
