@extends('layouts.app')
@section('styles')

@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="row">
                        @include('layouts.side-menu')
                        <div class="col-md-9 py-4 pl-lg-0">
                            <div class="mt-0">
                                <div class="col-md-12">

                                    <div class="questtions-label page-heading">Your Results</div>

                                    <div class="text-right">
                                        <button class="w-auto submit-btn btn btn-outline-theme btn-rounded waves-effect z-depth-0 m-0" onclick="printDiv()">
                                            Print Report
                                        </button>
                                    </div>
                                    <div id="to_print">
                                        <style>
                                            @media print {


                                                .h5, h5 {
                                                    font-size: 1.25rem;
                                                }

                                                .font-weight-500 {
                                                    font-weight: 500;
                                                }

                                                .mt-3, .my-3 {
                                                    margin-top: 1rem !important;
                                                }

                                                .progress {
                                                    position: relative;
                                                }

                                                .progress:before {
                                                    display: block;
                                                    content: '';
                                                    position: absolute;
                                                    top: 0;
                                                    right: 0;
                                                    bottom: 0;
                                                    left: 0;
                                                    z-index: 0;
                                                    border-bottom: 2rem solid #eeeeee;
                                                }

                                                .progress-bar {
                                                    position: absolute;
                                                    top: 0;
                                                    bottom: 0;
                                                    left: 0;
                                                    z-index: 1;
                                                    border-bottom: 2rem solid #337ab7;
                                                }

                                                .progress-bar-success {
                                                    border-bottom-color: #67c600;
                                                }

                                                .progress-bar-info {
                                                    border-bottom-color: #5bc0de;
                                                }

                                                .progress-bar-warning {
                                                    border-bottom-color: #f0a839;
                                                }

                                                .progress-bar-danger {
                                                    border-bottom-color: #ee2f31;
                                                }

                                                .progress, .progress-bar {
                                                    height: 1.5rem;
                                                    font-size: 1rem;
                                                }

                                                .progress-bar-striped {
                                                    background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
                                                    background-size: 1rem 1rem;
                                                    -webkit-print-color-adjust: exact;
                                                }

                                                .progress-bar {
                                                    display: -ms-flexbox;
                                                    display: flex;
                                                    -ms-flex-direction: column;
                                                    flex-direction: column;
                                                    -ms-flex-pack: center;
                                                    justify-content: center;
                                                    color: #fff;
                                                    text-align: center;
                                                    white-space: nowrap;
                                                    background-color: #007bff;
                                                    transition: width .6s ease;
                                                    -webkit-print-color-adjust: exact;
                                                }

                                                .progress {
                                                    display: -ms-flexbox;
                                                    display: flex;
                                                    height: 1rem;
                                                    overflow: hidden;
                                                    font-size: .75rem;
                                                    background-color: #e9ecef;
                                                    border-radius: .25rem;
                                                    -webkit-print-color-adjust: exact;
                                                }

                                                .row {
                                                    display: -ms-flexbox;
                                                    display: flex;
                                                    -ms-flex-wrap: wrap;
                                                    flex-wrap: wrap;
                                                }

                                                .col-md-5 {
                                                    -ms-flex: 0 0 41.666667%;
                                                    flex: 0 0 41.666667%;
                                                    max-width: 41.666667%;
                                                }

                                                .col-md-2 {
                                                    -ms-flex: 0 0 16.666667%;
                                                    flex: 0 0 16.666667%;
                                                    max-width: 16.666667%;
                                                }

                                                .col-md-12 {
                                                    -ms-flex: 0 0 100%;
                                                    flex: 0 0 100%;
                                                    max-width: 100%;
                                                }

                                                .alert-danger {
                                                    color: #721c24;
                                                    background-color: #f8d7da;
                                                    border-color: #f5c6cb;
                                                    -webkit-print-color-adjust: exact;
                                                }

                                                .alert {
                                                    position: relative;
                                                    padding: .75rem 1.25rem;
                                                    margin-bottom: 1rem;
                                                    border: 1px solid transparent;
                                                    border-radius: .25rem;
                                                }
                                                #breakdownChart{
                                                    display: none !important
                                                 }
                                                .see-where{
                                                    display: none;
                                                }
                                            }
                                        </style>
                                        @if($result == 'passed')
                                            <div class="alert alert-success mt-3" role="alert">
                                                YOU PASSED
                                            </div>
                                        @elseif($result == 'failed')
                                            <div class="alert alert-danger mt-3" role="alert">
                                                YOU FAILED
                                            </div>
                                        @elseif($result == 'quiz')
                                            <div class="alert alert-success mt-3" role="alert">
                                                Quiz Completed
                                            </div>
                                        @endif

                                        <div class="score-card">
                                            <div class="score"><strong>SCORE : </strong> {{ $correct }}/{{ $total }}
                                                ({{ ($correct/$total) * 100 }}%)
                                            </div>
                                            @if($average_duration)
                                                <div class="avg-time"><strong>Average Time Per
                                                        Question: </strong> {{ $average_duration }} min
                                                </div>
                                            @endif
                                        </div>

                                        <div class="breakdown">
                                            <h5 class="mt-3 font-weight-500">Breakdown</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if($categories->count())
                                                        @foreach($categories as $category)
                                                            @if($category->total > 0)
                                                                @php
                                                                    if($category->count > 0){
                                                                    $isScored = 1;
                                                                    }
                                                                    $percentage = ($category->count / $category->total) * 100;

                                                                @endphp
                                                                <div class="cat_progress row my-2">
                                                                    <div class="cat_total col-md-5">{{ $category->name }}</div>
                                                                    <div class="progress-cat col-md-5">
                                                                        <div class="progress">
                                                                            <div class="progress-bar progress-bar-striped"
                                                                                 role="progressbar"
                                                                                 style="width: {{ $percentage }}%"
                                                                                 aria-valuenow="{{ $percentage }}"
                                                                                 aria-valuemin="0"
                                                                                 aria-valuemax="100"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cat_total col-md-2">{{ ($category->count ? $category->count : 0).'/'.$category->total.' correct' }}</div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @if(isset($isScored))
                                                    <div class="col-md-12 mt-3 text-center">
                                                        <canvas id="breakdownChart"></canvas>
                                                        <img class="hide" id="canvasImage" src="">
                                                    </div>
                                                @endif
                                                <div class="col-md-12 mt-3 text-center see-where">
                                                    <a href="{{ route('report.card', $test_id) }}">See where you got
                                                        wrong.</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/printThis.js') }}" type="text/javascript"></script>
    <script>
        var backgroundColors = ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360", "#d4edda"];
        var hoverBackgroundColors = ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774", "#616774"];
        var args = {
            type: 'pie',
            data: {
                //labels: ["Red", "Green", "Yellow", "Grey", "Dark Grey"],
                labels: [],
                /*datasets: [{
                    data: [300, 50, 100, 40, 120],
                    backgroundColor: ,
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
                }]*/
                datasets: [{
                    //data: [300, 50, 100, 40, 120],
                    data: [],
                    backgroundColor: [],
                    hoverBackgroundColor: []
                }]
            },
            options: {
                responsive: true
            }
        }
        @foreach($categories as $key_cat =>  $category)
        @if($category->total > 0)
        args.data.labels.push('{!! $category->name !!}');
        args.data.datasets[0].data.push('{{$category->count}}');
        args.data.datasets[0].backgroundColor.push(backgroundColors['{{$key_cat}}']);
        args.data.datasets[0].hoverBackgroundColor.push(hoverBackgroundColors['{{$key_cat}}']);
                @endif
                @endforeach
                @if(isset($isScored))
        var ctxP = document.getElementById("breakdownChart").getContext('2d');
        var myPieChart = new Chart(ctxP, args);
        @endif
        function printDiv()
        {
            var dataUrl = document.getElementById('breakdownChart').toDataURL();
            document.getElementById('canvasImage').setAttribute('src',dataUrl);


            var divToPrint=document.getElementById('to_print');

            var newWin=window.open('','Print-Window');

            newWin.document.open();

            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

            newWin.document.close();

            setTimeout(function(){newWin.close();},10);



        }
    </script>
@endsection