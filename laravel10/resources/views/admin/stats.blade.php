@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Statistiques : Achat vs Vente par mois</h2>

    <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Radial Bar Chart</h5>

            <!-- Radial Bar Chart -->
            <div id="radialBarChart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#radialBarChart"), {
                  series: [44, 55, 67, 83],
                  chart: {
                    height: 350,
                    type: 'radialBar',
                    toolbar: {
                      show: true
                    }
                  },
                  plotOptions: {
                    radialBar: {
                      dataLabels: {
                        name: {
                          fontSize: '22px',
                        },
                        value: {
                          fontSize: '16px',
                        },
                        total: {
                          show: true,
                          label: 'Total',
                          formatter: function(w) {
                            // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                            return 249
                          }
                        }
                      }
                    }
                  },
                  labels: ['Apples', 'Oranges', 'Bananas', 'Berries'],
                }).render();
              });
            </script>
            <!-- End Radial Bar Chart -->

          </div>
        </div>
      </div>
@endsection
