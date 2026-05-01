@props(['male', 'female'])

<!-- Chart Container -->
<div class="bg-white p-1 rounded-lg shadow-lg w-full">
    <div class="relative w-full h-52 mt-2.5" x-data="activePersonsData()">
        <canvas id="activePersonsChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>

<script>
    function activePersonsData() {
        return {
            males: {{ $male }},
            females: {{ $female }},
            init() {
                const ctx = document.getElementById('activePersonsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Male : {{ $male }}', 'Female : {{ $female }}'],
                        datasets: [{
                            label: 'Active Persons',
                            data: [this.males, this.females],
                            backgroundColor: ['#3B82F6', '#F43F5E'],
                            borderColor: ['#FFFFFF', '#FFFFFF'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 10,
                                    boxWidth: 20,
                                    font: {
                                        weight: 'bold',
                                        size: 13
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        const label = tooltipItem.label ? tooltipItem.label.split(":")[0] :
                                            '';
                                        const value = tooltipItem.raw;
                                        return `${label}: ${value}`;
                                    }
                                }
                            }
                        },
                        elements: {
                            arc: {
                                borderWidth: 1
                            }
                        }
                    }
                });
            }
        }
    }
</script>
